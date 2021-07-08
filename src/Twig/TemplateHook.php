<?php


namespace Rock\Core\Twig;


use Twig\Environment;

abstract class TemplateHook implements HookInterface
{
    protected Environment $templating;
    public string $target;

    public function __construct(Environment $templating)
    {
        $this->templating = $templating;

        if(method_exists($this, 'setTarget')) {
            $this->target = $this->setTarget();
        }
    }

}