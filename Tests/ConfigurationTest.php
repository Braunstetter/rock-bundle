<?php

namespace Rock\Tests;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionConfigurationTestCase;
use Rock\DependencyInjection\Configuration;
use Rock\DependencyInjection\RockExtension;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

class ConfigurationTest extends AbstractExtensionConfigurationTestCase
{
    protected function getContainerExtension(): ExtensionInterface
    {
        return new RockExtension();
    }

    protected function getConfiguration(): ConfigurationInterface
    {
        return new Configuration();
    }

    public function test_configuration_has_rock_tree()
    {
        $this->assertProcessedConfigurationEquals([], [
            __DIR__ . '/Functional/app/Cases/general/rock.yml'
        ]);
    }

}
