<?php


namespace Rock\Core\Twig;


use JetBrains\PhpStorm\Pure;
use Rock\Core\Twig\TokenParser\HookTokenParser;
use Twig\Extension\AbstractExtension;

class Extension extends AbstractExtension
{
    private Renderer $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @return HookTokenParser[]
     */
    #[Pure] public function getTokenParsers(): array
    {
        return [
          new HookTokenParser($this->renderer)
        ];
    }
}