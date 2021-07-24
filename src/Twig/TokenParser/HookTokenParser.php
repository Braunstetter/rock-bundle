<?php


namespace Rock\Twig\TokenParser;


use Rock\Twig\Nodes\HookNode;
use Rock\Twig\Renderer;
use Twig\Node\Expression\ConstantExpression;
use Twig\Node\Node;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

class HookTokenParser extends AbstractTokenParser
{
    private Renderer $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @inheritDoc
     */
    public function parse(Token $token): Node|HookNode
    {
        $lineno = $token->getLine();
        $parser = $this->parser;
        $stream = $parser->getStream();

        /** @var ConstantExpression $node */
        $node = $parser->getExpressionParser()->parseExpression();

        $nodes = [
            'hook' => $node,
        ];

        $stream->expect(Token::BLOCK_END_TYPE);
        return new HookNode($nodes, ['renderer' => $this->renderer], $lineno, $this->getTag());
    }

    /**
     * @inheritDoc
     */
    public function getTag(): string
    {
        return 'hook';
    }
}