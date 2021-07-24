<?php


namespace Rock\Services;


use ReflectionClass;
use ReflectionException;
use Rock\Contracts\PluginInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\AbstractString;
use Symfony\Component\String\UnicodeString;

class Plugins
{
    private iterable $plugins;

    public function __construct(iterable $plugins)
    {
        $this->plugins = $plugins;
    }

    public function findAll(): iterable
    {
        return $this->plugins;
    }

    /**
     * @throws ReflectionException
     */
    public function find(string $className)
    {
        foreach ($this->plugins as $plugin) {
            if ((new ReflectionClass($plugin))->getName() === $className) {
                return $plugin;
            }
        }

        return null;
    }

    public function resolvePluginOptions(PluginInterface $plugin): array
    {
        $optionResolver = new OptionsResolver();
        $this->setDefaults($optionResolver, $plugin);

        $plugin->configureOptions($optionResolver);
        return $optionResolver->resolve();
    }

    private function setDefaults(OptionsResolver $optionsResolver, PluginInterface $plugin): void
    {

        $optionsResolver
            ->define('name')
            ->allowedTypes('string')
            ->default($this->generateNameFromClassname($plugin))
            ->info('The name of this bundle. If it\'s not set it will be generated from the classname of the plugin class.');

        $optionsResolver->setDefault('class', $this->getClassName($plugin));
        $optionsResolver->setAllowedTypes('class', ['string']);

        $optionsResolver->setDefault('nav', function (OptionsResolver $navResolver) {
            $navResolver->setDefaults([
                'hasItem' => true,
                'isSection' => false
            ]);

            $navResolver->setAllowedTypes('hasItem', ['bool']);
            $navResolver->setInfo('hasItem', 'Whether this bundle should have a menu entry or not');

            $navResolver->setAllowedTypes('isSection', ['bool']);
            $navResolver->setInfo('isSection', 'If this value is true, a menu item is created for this bundle, which is displayed as a section.');
        });
    }

    private function generateNameFromClassname(PluginInterface $plugin): string
    {
        return (new UnicodeString($this->getShortClassName($plugin)))
            ->snake()
            ->toString();
    }

    private function getClassName(PluginInterface $plugin): string
    {
        return (new ReflectionClass($plugin))->getName();
    }

    private function getShortClassName(PluginInterface $plugin): string
    {
        return (new ReflectionClass($plugin))->getShortName();
    }

}