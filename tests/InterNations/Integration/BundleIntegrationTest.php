<?php

namespace InterNations\Bundle\TypeJailBundle\Integration;

use InterNations\Bundle\TypeJailBundle\Factory\NullFactory;
use InterNations\Bundle\TypeJailBundle\Integration\app\AppKernel;
use InterNations\Bundle\TypeJailBundle\Integration\Fixtures\Clazz;
use InterNations\Bundle\TypeJailBundle\Integration\Fixtures\SubClass;
use InterNations\Bundle\TypeJailBundle\Manager\TypeAliasManager;
use InterNations\Component\TypeJail\Exception\JailException;
use InterNations\Component\TypeJail\Factory\JailFactory;
use InterNations\Component\TypeJail\Factory\SuperTypeFactory;
use InterNations\Component\TypeJail\Factory\SuperTypeJailFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Twig\Error\RuntimeError as TwigRuntimeError;

/**
 * @group integration
 * @group large
 */
class BundleIntegrationTest extends WebTestCase
{
    /** @return array[] */
    public static function getFactories(): iterable
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
		$options['config'] = $config;
		$options['debug'] = $debug;
		self::bootKernel($options);
        $factory = self::$kernel->getContainer()->get('inter_nations.type_jail.factory');

        self::assertInstanceOf($expectedClass, $factory);
    }

    public function testTypeManagerConfiguration(): void
    {
		$options['config'] = 'jail.yml';
		$options['debug'] = true;
		self::bootKernel($options);
        $typeManager = self::getContainer()->get('inter_nations.type_jail.manager.type_alias_manager');

        self::assertInstanceOf(TypeAliasManager::class, $typeManager);
        self::assertSame(Clazz::class, $typeManager->getType('alias1'));
    }

    public function testRenderInstanceTemplate(): void
    {
		$options['config'] = 'super-type-jail.yml';
		$options['debug'] = true;
		self::bootKernel($options);
		$templating = self::getContainer()->get('twig');

        try {
            $templating->render('instance.html.twig', ['obj' => new SubClass()]);
            self::fail('Exception expected');
        } catch (TwigRuntimeError $e) {
            self::assertInstanceOf(JailException::class, $e->getPrevious());
        }
    }

    public function testRenderNullTemplate(): void
    {
		$options['config'] = 'super-type-jail.yml';
		$options['debug'] = true;
		self::bootKernel($options);
		$templating = self::getContainer()->get('twig');

        try {
            $templating->render('instance-or-null.html.twig', ['obj' => new SubClass()]);
            self::fail('Exception expected');
        } catch (TwigRuntimeError $e) {
            self::assertInstanceOf(JailException::class, $e->getPrevious());
        }
    }

    public function testRenderAggregateTemplate(): void
    {
		$options['config'] = 'super-type-jail.yml';
		$options['debug'] = true;
		self::bootKernel($options);
        $templating = static::getContainer()->get('twig');

        try {
            $templating->render('aggregate.html.twig', ['list' => [new SubClass(), new SubClass()]]);
            self::fail('Exception expected');
        } catch (TwigRuntimeError $e) {
            self::assertInstanceOf(JailException::class, $e->getPrevious());
        }
    }

	protected static function createKernel(array $options = []): KernelInterface
	{
		static::$class = AppKernel::class;
		return new static::$class($options['config'], 'test', $options['debug']);
	}
}
