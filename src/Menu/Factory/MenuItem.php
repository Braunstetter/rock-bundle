<?php


namespace Rock\Menu\Factory;


use Rock\Menu\Items\RouteMenuItem;
use Rock\Menu\Items\SectionMenuItem;
use Rock\Menu\Items\SystemMenuItem;

final class MenuItem
{

    public static function linkToRoute(string $label, string $routeName, array $routeParameters = [], ?string $icon = null): RouteMenuItem
    {
        return new RouteMenuItem($label, $routeName, $routeParameters, $icon);
    }

    public static function section(string $label, string $routeName, array $routeParameters = [], ?string $icon = null): SectionMenuItem
    {
        return new SectionMenuItem($label, $routeName, $routeParameters, $icon);
    }

   public static function system(string $label, string $routeName, array $routeParameters = [], ?string $icon = null): SystemMenuItem
    {
        return new SystemMenuItem($label, $routeName, $routeParameters, $icon);
    }

}