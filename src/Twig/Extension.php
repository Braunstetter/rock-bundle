<?php


namespace Rock\Twig;


use JetBrains\PhpStorm\Pure;
use Rock\Services\Menu;
use Rock\Twig\TokenParser\HookTokenParser;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigTest;

class Extension extends AbstractExtension
{
    private Renderer $renderer;
    private Menu $menu;
    private Environment $templating;

    public function __construct(Renderer $renderer, Menu $menu, Environment $templating)
    {
        $this->renderer = $renderer;
        $this->menu = $menu;
        $this->templating = $templating;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('hook', [$this->renderer, 'invokeHook'], ['is_safe' => ['html'], 'needs_context' => true]),
            new TwigFunction('rock_menu', [$this, 'getRockMenu'], ['is_safe' => ['html'], 'needs_context' => true])
        ];
    }


    /**
     * @return HookTokenParser[]
     */
    #[Pure] public function getTokenParsers(): array
    {
        return [
//            new HookTokenParser($this->renderer)
        ];
    }

    /**
     * @inheritdoc
     */
    public function getTests(): array
    {
        return [
            new TwigTest('instance of', function ($obj, $class) {
                return $obj instanceof $class;
            }),
            new TwigTest('boolean', function ($obj): bool {
                return is_bool($obj);
            }),
        ];
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function getRockMenu($context, $name): string
    {

        $selectedSubnavItem = array_key_exists('selectedSubnavItem', $context)
            ? $context['selectedSubnavItem']
            : null;

        return $this->templating->render('@Rock/menu/main.html.twig',
            [
                'menus' => $this->menu->getTree($name, $selectedSubnavItem)
            ]
        );
    }
}