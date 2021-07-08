<?php


namespace Rock\Core\Twig\Nodes;

use Exception;
use Rock\Core\Twig\Renderer;
use Twig\Compiler;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Node\Expression\ConstantExpression;
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

        $hookName = $this->getNode('hook')->getAttribute('value');

        try {
            $hookContent = $renderer->invokeHook($hookName);
        } catch (LoaderError | RuntimeError | SyntaxError $e) {
            throw new Exception($e);
        }

        $compiler
            ->addDebugInfo($this)
            ->write("echo '$hookContent';");
    }
}
