<?php


namespace Rock\Test\functional;


use PHPUnit\Framework\TestCase;
use ReflectionException;
use Rock\Services\Plugins;
use Rock\Test\app\src\Rock;
use Rock\Test\app\src\RockWithCustomName;
use Rock\Test\app\src\TestKernel;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PluginsTest extends TestCase
{
    protected TestKernel $kernel;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $kernel = new TestKernel('dev', true);
        $kernel->boot();

        $this->kernel = $kernel;
    }

    public function testPluginsGetDetected()
    {
        /** @var Plugins $pluginsClass */
        $pluginsClass = $this->kernel->getContainer()->get('Rock\Services\Plugins');
        $this->assertCount(2, $pluginsClass->findAll());
    }

//    /**
//     * @throws ReflectionException
//     */
//    public function testOptionsGetResolved()
//    {
//        /** @var Plugins $pluginsClass */
//        $pluginsClass = $this->kernel->getContainer()->get('Rock\Services\Plugins');
//        $plugin = $plugin = $pluginsClass->find(Rock::class);
//
//        $options = $pluginsClass->resolvePluginOptions($plugin);
//        $this->assertSame(['name' => 'rock'], $options);
//    }
//
//    public function testNameCanBeOverwritten()
//    {
//        /** @var Plugins $pluginsClass */
//        $pluginsClass = $this->kernel->getContainer()->get('Rock\Services\Plugins');
//
//        $plugin = $pluginsClass->find(RockWithCustomName::class);
//        $options = $pluginsClass->resolvePluginOptions($plugin);
//
//        $this->assertSame(['name' => 'custom_name'], $options);
//    }

    public function testMenuItemsCanBeExtracted()
    {
        /** @var Plugins $pluginsClass */
        $menu = $this->kernel->getContainer()->get('Rock\Menu\MainMenu');

        $this->assertSame([], $menu->getMenuItems());

    }


}