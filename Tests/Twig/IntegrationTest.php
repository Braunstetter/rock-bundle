<?php

namespace Rock\Tests\Twig;

use Rock\Twig\Extension;
use Twig\Test\IntegrationTestCase;

class IntegrationTest extends IntegrationTestCase
{
    public function getExtensions() : array
    {
        return [
            new Extension()
        ];
    }

    protected function getFixturesDir(): string
    {
        return __DIR__ . '/Fixtures';
    }
}