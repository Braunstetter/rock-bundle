<?php


namespace Rock\Services;


use Rock\Menu\Items\MenuItem;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Menu
{
    private iterable $entries;
    private RequestStack $requestStack;
    private UrlGeneratorInterface $generator;


    private $selectedSubnavItem;

    /**
     * Menu constructor.
     * @param iterable $entries
     */
    public function __construct(iterable $entries, RequestStack $requestStack, UrlGeneratorInterface $generator)
    {
        $this->entries = $entries;
        $this->requestStack = $requestStack;
        $this->generator = $generator;
    }

    public function getTree($name, &$selectedSubnavItem)
    {
        if (isset($selectedSubnavItem)) $this->selectedSubnavItem = $selectedSubnavItem;

        $result = [];

        foreach ($this->entries as $menu) {
            if ($menu->handle === $name) {
                $result = $this->resolve($menu, $result);
            }
        }

        return $result;
    }

    /**
     * @param mixed $menu
     * @param array $result
     * @return array
     */
    private function resolve(mixed $menu, array $result): array
    {
        foreach (call_user_func($menu) as $item) {
            $this->isCurrent($item);
            $result[] = $item;
        }

        return $result;
    }

    private function isCurrent(MenuItem $item)
    {

        if ($this->matches($item)) {
            return true;
        }

        if ($this->oneOfTheChildrenMatches($item)) {
            return true;
        }

        return false;
    }

    private function matches(MenuItem $item)
    {
        if ($this->selectedSubnavItemMatches($item)) {
            $item->setCurrent(true);
            return true;
        }

        $uri = $this->generator->generate($item->getRouteName());

        if ($uri === $this->requestStack->getCurrentRequest()->getPathInfo()) {
            $item->setCurrent(true);
            return true;
        }

        return false;
    }

    private function oneOfTheChildrenMatches(MenuItem $item)
    {
        if (!empty($item->getChildren())) {

            foreach ($item->getChildren() as $subItem) {

                if ($this->matches($subItem)) {
                    $item->setInActiveTrail(true);
                    return true;
                }

                if ($this->oneOfTheChildrenMatches($subItem)) {
                    $item->setInActiveTrail(true);
                    return true;
                }

            }

            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getSelectedSubnavItem()
    {
        return $this->selectedSubnavItem;
    }

    /**
     * @param mixed $selectedSubnavItem
     */
    public function setSelectedSubnavItem($selectedSubnavItem): void
    {
        $this->selectedSubnavItem = $selectedSubnavItem;
    }

    /**
     * @param MenuItem $item
     */
    private function selectedSubnavItemMatches(MenuItem $item): bool
    {
        return $item->handle === $this->selectedSubnavItem;
    }


}