<?php


namespace Rock\Twig\Nodes;

use Exception;
use Rock\Twig\Renderer;
use Twig\Compiler;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Node\Node;

/**
 * Class HookNode
 *
 * @author Braunstetter GmbH. <support@braunstetter.com>
 */
class HookNode extends Node
{
    /**
     * @inheritdoc
     * @throws Exception
     */
    public function compile(Compiler $compiler)
    {
        /** @var Renderer $renderer */
        $renderer = $this->getAttribute('renderer');

        $hookContent = $renderer->invokeHook(
            $this->getNode('hook')->getAttribute('value')
        );

        $compiler
            ->addDebugInfo($this)
            ->write("echo '$hookContent';");
    }
}
