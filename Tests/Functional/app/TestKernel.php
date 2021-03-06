<?php


namespace Rock\Tests\Functional\app;


use Rock\RockBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class TestKernel extends Kernel
{
    private $varDir;
    private $testCase;
    private $rootConfig;
    private $authenticatorManagerEnabled;

    public function __construct($varDir, $testCase, $rootConfig, $environment, $debug, $authenticatorManagerEnabled = false)
    {
        if (!is_dir(__DIR__.'/Cases/'.$testCase)) {
            throw new \InvalidArgumentException(sprintf('The test case "%s" does not exist.', $testCase));
        }
        $this->varDir = $varDir;
        $this->testCase = $testCase;

        $fs = new Filesystem();
        foreach ((array) $rootConfig as $config) {
            if (!$fs->isAbsolutePath($config) && !is_file($config = __DIR__.'/Cases/'.$testCase.'/'.$config)) {
                throw new \InvalidArgumentException(sprintf('The root config "%s" does not exist.', $config));
            }

            $this->rootConfig[] = $config;
        }
        $this->authenticatorManagerEnabled = $authenticatorManagerEnabled;

        parent::__construct($environment, $debug);
    }

    /**
     * {@inheritdoc}
     */
    public function getContainerClass(): string
    {
        return parent::getContainerClass().substr(md5(implode('', $this->rootConfig).$this->authenticatorManagerEnabled), -16);
    }

    public function registerBundles(): iterable
    {
        if (!is_file($filename = $this->getProjectDir().'/Cases/'.$this->testCase.'/bundles.php')) {
            throw new \RuntimeException(sprintf('The bundles file "%s" does not exist.', $filename));
        }

        return include $filename;
    }

    public function getProjectDir(): string
    {
        return __DIR__;
    }

    public function getCacheDir(): string
    {
        return sys_get_temp_dir().'/'.$this->varDir.'/'.$this->testCase.'/cache/'.$this->environment;
    }

    public function getLogDir(): string
    {
        return sys_get_temp_dir().'/'.$this->varDir.'/'.$this->testCase.'/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        foreach ($this->rootConfig as $config) {
            $loader->load($config);
        }

        if ($this->authenticatorManagerEnabled) {
            $loader->load(function ($container) {
                $container->loadFromExtension('security', [
                    'enable_authenticator_manager' => true,
                ]);
            });
        }
    }

    public function serialize()
    {
        return serialize([$this->varDir, $this->testCase, $this->rootConfig, $this->getEnvironment(), $this->isDebug()]);
    }

    public function unserialize($str)
    {
        $a = unserialize($str);
        $this->__construct($a[0], $a[1], $a[2], $a[3], $a[4]);
    }

    protected function getKernelParameters(): array
    {
        $parameters = parent::getKernelParameters();
        $parameters['kernel.test_case'] = $this->testCase;

        return $parameters;
    }

}