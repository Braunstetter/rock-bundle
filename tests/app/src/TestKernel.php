<?php


namespace Rock\Test\app\src;


use Rock\RockBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class TestKernel extends Kernel
{

    use MicroKernelTrait;

    /**
     * @inheritDoc
     */
    public function registerBundles(): iterable
    {
        return [
            new FrameworkBundle(),
            new RockBundle(),
            new TwigBundle()
        ];
    }

    protected function configureContainer(ContainerConfigurator $container)
    {
        $container->extension('framework', [
            'secret' => "F00",
            'router' => ['utf8' => true]
        ]);

        $container->extension('twig', [
            'paths' => ['tests/app/src/Resources/views' => '__main__']
        ]);

        $container->import('Resources/config/services_test.yaml');
        $container->import('Resources/config/controller_test.yaml');
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $routes->import(__DIR__ . '/Resources/config/routes_test.yaml');
    }
}