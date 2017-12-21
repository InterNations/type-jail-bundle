<?php
namespace InterNations\Bundle\TypeJailBundle\Tests\Integration;

use InterNations\Bundle\TypeJailBundle\Factory\NullFactory;
use InterNations\Bundle\TypeJailBundle\Manager\TypeAliasManager;
use InterNations\Bundle\TypeJailBundle\Tests\Integration\Fixtures\Clazz;
use InterNations\Bundle\TypeJailBundle\Tests\Integration\Fixtures\SubClass;
use InterNations\Component\Testing\AbstractTestCase;
use InterNations\Bundle\TypeJailBundle\Tests\Integration\app\AppKernel;
use InterNations\Component\TypeJail\Exception\JailException;
use InterNations\Component\TypeJail\Factory\JailFactory;
use InterNations\Component\TypeJail\Factory\SuperTypeFactory;
use InterNations\Component\TypeJail\Factory\SuperTypeJailFactory;
use Twig\Error\RuntimeError as TwigRuntimeError;

/**
 * @group integration
 * @group large
 */
class BundleIntegrationTest extends AbstractTestCase
{
    public static function getFactories()
    {
        return [
            ['default.yml', JailFactory::class, true],
            ['force-enabled.yml', JailFactory::class, true],
            ['force-enabled.yml', JailFactory::class, false],
            ['jail.yml', JailFactory::class, true],
            ['super-type.yml', SuperTypeFactory::class, true],
            ['super-type-jail.yml', SuperTypeJailFactory::class, true],
            ['default.yml', NullFactory::class, false],
            ['jail.yml', NullFactory::class, false],
            ['super-type.yml', NullFactory::class, false],
            ['super-type-jail.yml', NullFactory::class, false],
        ];
    }

    /** @dataProvider getFactories */
    public function testFactoryConfiguration(string $config, string $expectedClass, bool $debug): void
    {
        $container = $this->getContainer($config, $debug);
        $factory = $container->get('inter_nations.type_jail.factory');

        $this->assertInstanceOf($expectedClass, $factory);
    }

    public function testTypeManagerConfiguration()
    {
        $container = $this->getContainer('jail.yml', true);
        $typeManager = $container->get('inter_nations.type_jail.manager.type_alias_manager');

        $this->assertInstanceOf(TypeAliasManager::class, $typeManager);
        $this->assertSame(Clazz::class, $typeManager->getType('alias1'));
    }

    public function testRenderInstanceTemplate()
    {
        $container = $this->getContainer('super-type-jail.yml', true);
        $templating = $container->get('templating');

        try {
            $templating->render('instance.html.twig', ['obj' => new SubClass()]);
            $this->fail('Exception expected');
        } catch (TwigRuntimeError $e) {
            $this->assertInstanceOf(JailException::class, $e->getPrevious());
        }
    }

    public function testRenderNullTemplate()
    {
        $container = $this->getContainer('super-type-jail.yml', true);
        $templating = $container->get('templating');

        try {
            $templating->render('instance-or-null.html.twig', ['obj' => new SubClass()]);
            $this->fail('Exception expected');
        } catch (TwigRuntimeError $e) {
            $this->assertInstanceOf(JailException::class, $e->getPrevious());
        }
    }

    public function testRenderAggregateTemplate()
    {
        $container = $this->getContainer('super-type-jail.yml', true);
        $templating = $container->get('templating');

        try {
            $templating->render('aggregate.html.twig', ['list' => [new SubClass(), new SubClass()]]);
            $this->fail('Exception expected');
        } catch (TwigRuntimeError $e) {
            $this->assertInstanceOf(JailException::class, $e->getPrevious());
        }
    }

    private function getContainer($config, $debug)
    {
        $kernel = new AppKernel($config, 'prod', $debug);
        $kernel->boot();

        return $kernel->getContainer();
    }
}
