<?php


namespace Rock\Routes;

use Rock\Events\RegisterCpRoutesEvent;
use Rock\Events\Events;
use RuntimeException;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class RouteLoader extends Loader
{
    public const ROUTE_TYPE_NAME = 'rock_admin';

    private bool $isLoaded = false;
    private EventDispatcherInterface $eventDispatcher;

    /**
     * RouteLoader constructor.
     * @param string|null $env
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(string $env = null, EventDispatcherInterface $eventDispatcher)
    {
        parent::__construct($env);
        $this->eventDispatcher = $eventDispatcher;
    }


    public function load($resource, string $type = null): RouteCollection
    {
        if (true === $this->isLoaded) {
            throw new RuntimeException('Do not add the "Rock\Routes\RouteLoader" loader twice');
        }

        $collection = new RouteCollection();

        $event = new RegisterCpRoutesEvent($collection);
        $this->eventDispatcher->dispatch($event, Events::BEFORE_REGISTER_CP_ROUTES);

        $this->loadRoutingFile($collection);

        $event = new RegisterCpRoutesEvent($collection);
        $this->eventDispatcher->dispatch($event, Events::AFTER_REGISTER_CP_ROUTES);

        return $collection;
    }

    /**
     * @param RouteCollection $collection
     */
    private function loadRoutingFile(RouteCollection $collection): void
    {
        $resource = '@RockBundle/Resources/config/routes.yaml';
        $type = 'yaml';
        $importedRoutes = $this->import($resource, $type);
        $collection->addCollection($importedRoutes);

        $this->isLoaded = true;
    }

    public function supports($resource, string $type = null): bool
    {
        return self::ROUTE_TYPE_NAME === $type;
    }

}