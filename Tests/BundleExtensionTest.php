<?php

namespace Rock\Tests;

use Rock\DependencyInjection\RockExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class BundleExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [new RockExtension()];
    }

    public function test_twig_extension_gets_loaded()
    {
        $this->load();
        $this->assertContainerBuilderHasService('Rock\Twig\Extension');
    }

}