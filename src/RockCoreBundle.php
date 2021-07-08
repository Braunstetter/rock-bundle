<?php


namespace Rock\Core;

use Rock\Core\DependencyInjection\RockExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class RockCoreBundle extends Bundle
{
    public function getContainerExtension(): bool|RockExtension|ExtensionInterface|null
    {
        if (null === $this->extension) {
            $this->extension = new RockExtension();
        }

        return $this->extension;
    }

}