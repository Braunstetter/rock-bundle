<?php


namespace Rock\Core\Twig;


use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Renderer
{
    private iterable $hooks;
    private Environment $templating;

    public function __construct(iterable $hooks, Environment $templating)
    {
        $this->hooks = $hooks;
        $this->templating = $templating;
    }

    /**
     * @param $name
     * @return string
     */
    public function invokeHook($name): string
    {
        $return = '';

        foreach ($this->hooks as $hook) {

            /** @var TemplateHook $hook */
            if ($hook->target === $name) {
                $return .= $hook->render();
            }
        }

        return $return;
    }
}