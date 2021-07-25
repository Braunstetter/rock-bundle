<?php


namespace Rock\Routes;


use Braunstetter\PluginBundle\Routes\Loader;

class RouteLoader extends Loader
{
    public function resource(): string
    {
        return '@RockBundle/Resources/config/routes.yaml';
    }
}