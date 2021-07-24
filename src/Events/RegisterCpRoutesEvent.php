<?php


namespace Rock\Events;


use Symfony\Component\Routing\RouteCollection;
use Symfony\Contracts\EventDispatcher\Event;

class RegisterCpRoutesEvent extends Event
{
    private RouteCollection $collection;

    public function __construct(RouteCollection $collection)
    {
        $this->collection = $collection;
    }

}