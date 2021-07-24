<?php


namespace Rock\Contracts;


use Symfony\Component\OptionsResolver\OptionsResolver;

interface PluginInterface
{
    /**
     * Configures the options for this plugin.
     */
    public function configureOptions(OptionsResolver $resolver);
}