<?php


namespace Rock\Menu\Items;


use Rock\Menu\MenuItemTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;

class MenuItem
{
    public const TYPE_SECTION = 'section';
    public const TYPE_SYSTEM = 'system';
    public const TYPE_ROUTE = 'route';

    use MenuItemTrait;
}