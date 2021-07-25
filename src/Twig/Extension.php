<?php


namespace Rock\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigTest;

class Extension extends AbstractExtension
{

    public function getFunctions(): array
    {
        return [
//            new TwigFunction('rock_menu', [$this, 'getRockMenu'], ['is_safe' => ['html'], 'needs_context' => true])
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

}