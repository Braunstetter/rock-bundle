<?php


namespace Rock\DependencyInjection;


use Exception;
use Rock\Contracts\CpMenuInterface;
use Rock\Twig\Contracts\HookInterface;
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

        $container->registerForAutoconfiguration(HookInterface::class)
            ->addTag('rock.template_hook');

        $container->registerForAutoconfiguration(CpMenuInterface::class)
            ->addTag('rock.cp_menu');
    }


//    public function prepend(ContainerBuilder $container)
//    {
//        $bundles = $container->getParameter('kernel.bundles');
//
//        if (isset($bundles['TwigBundle'])) {
//
//            $config = $container->getExtensionConfig('twig')[0];
//            $paths = ['/web' => 'web'];
//
//            if (array_key_exists('path', $config)) {
//                $paths = array_merge($config['paths'], $paths);
//            }
//
//            $config['paths'] = $paths;
//
//            $container->prependExtensionConfig('twig', $config);
//        }
//    }

}