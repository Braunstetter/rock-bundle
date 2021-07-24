<?php


namespace Rock\Test\app\src\Twig;

use Rock\Twig\TemplateHook;

class MyHook extends TemplateHook
{

    public function render(): string
    {
        return $this->templating->render('template_hook/template_hook_hook_template.html.twig');
    }

    public function setTarget(): string
    {
        return 'my-custom-hook-name';
    }

}