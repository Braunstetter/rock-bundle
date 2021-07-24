<?php


namespace Rock\Menu;


use Rock\Services\Plugins;

class MainMenu
{
    private Plugins $plugins;

    /**
     * MainMenu constructor.
     * @param Plugins $plugins
     */
    public function __construct(Plugins $plugins)
    {
        $this->plugins = $plugins;
    }

    public function getMenuItems(): array
    {
        $results = [];

        $iterator = new MenuIterator($this->plugins->findAll());
        $plugins = $iterator->getAll();

        foreach ($plugins as $plugin) {
            $results[] = $this->plugins->resolvePluginOptions($plugin);
        }

        return array_filter($results, function ($result) {
            return $result['nav']['hasItem'];
        });
    }


}