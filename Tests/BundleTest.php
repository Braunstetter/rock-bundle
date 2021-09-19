<?php

namespace Rock\Tests;

use Nyholm\BundleTest\AppKernel;
use Rock\DependencyInjection\RockExtension;
use Rock\RockBundle;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

class BundleTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return AppKernel::class;
    }

    protected static function createKernel(array $options = []): KernelInterface
    {
        /**
         * @var AppKernel $kernel
         */
        $kernel = parent::createKernel($options);
        $kernel->addBundle(RockBundle::class);

        return $kernel;
    }

    public function testInitBundle(): void
    {
        self::bootKernel();
        $bundle = self::$kernel->getBundle('RockBundle');
        $this->assertInstanceOf(RockBundle::class, $bundle);
        $this->assertInstanceOf(RockExtension::class, $bundle->getContainerExtension());
    }

}