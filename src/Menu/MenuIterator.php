<?php


namespace Rock\Menu;


class MenuIterator
{
    private iterable $plugins;

    public function __construct(iterable $plugins)
    {
        $this->plugins = $plugins;
    }

    public function getAll(): array
    {
        $results = [];

        foreach ($this->plugins as $plugin) {
            $results[] = $plugin;
        }

        return $results;
    }

}