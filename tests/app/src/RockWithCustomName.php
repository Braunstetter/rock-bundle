<?php


namespace Rock\Test\app\src;

use Rock\Plugin;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RockWithCustomName extends Plugin
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'name' => 'custom_name',
            'nav' => [
                'hasItem' => false
            ]
        ]);
    }

}