<?php

namespace Rock\Test\functional;

use Exception;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Rock\Test\app\src\TestKernel;
use Rock\Twig\Nodes\HookNode;
use Rock\Twig\TokenParser\HookTokenParser;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Twig\Environment;
use Twig\Error\SyntaxError;
use Twig\Loader\LoaderInterface;
use Twig\Node\Expression\ConstantExpression;
use Twig\Parser;
use Twig\Source;

class TemplateHookTest extends TestCase
{

    protected TestKernel $kernel;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $kernel = new TestKernel('dev', true);
        $kernel->boot();

        $this->kernel = $kernel;
    }

    /**
     * @throws SyntaxError
     * @throws Exception
     * @dataProvider getSources
     */
    public function test($source, $expected)
    {
        /** @var ContainerInterface $container */
        $container = $this->kernel->getContainer();
        $renderer = $container->get('Rock\Twig\Renderer');

        $env = new Environment($this->createMock(LoaderInterface::class), ['cache' => false, 'autoescape' => false, 'optimizations' => 0]);
        $env->addTokenParser(new HookTokenParser($renderer));
        $source = new Source($source, '');
        $stream = $env->tokenize($source);
        $parser = new Parser($env);

        $expected->setSourceContext($source);

        $this->assertEquals($expected, $parser->parse($stream)->getNode('body')->getNode(0));
    }

    public function testControllerOutput()
    {
        $client = new KernelBrowser($this->kernel);
        $client->request('GET','/template-hook-test');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(
            0,
            $client->getCrawler()->filter('html:contains("template hook works")')->count()
        );
    }

    public function getSources(): array
    {
        $container = $this->kernel->getContainer();

        return [
            [
                "{% hook 'my-custom-hook-name' %}",

                new HookNode(['hook' => new ConstantExpression('my-custom-hook-name', 1)],
                    ['renderer' => $container->get('Rock\Twig\Renderer')
                    ], 1, 'hook')
            ]
        ];
    }

    protected static function getKernelClass(): TestKernel
    {
        return new TestKernel('dev', true);
    }

}
