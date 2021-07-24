<?php


namespace Rock;


use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class Plugin implements Contracts\PluginInterface
{
    public function configureOptions(OptionsResolver $resolver): void
    {
    }
}