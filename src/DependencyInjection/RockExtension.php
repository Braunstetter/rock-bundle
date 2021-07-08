<?php


namespace Rock\Core\DependencyInjection;


use Exception;
use Rock\Core\Twig\HookInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class RockExtension extends Extension
{

    public function getAlias(): string
    {
        return 'rock';
    }


    /**
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->registerForAutoconfiguration(HookInterface::class)
            ->addTag('rock.template_hook')
        ;
    }
}