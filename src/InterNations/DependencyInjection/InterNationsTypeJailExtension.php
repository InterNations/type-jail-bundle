<?php
namespace InterNations\Bundle\TypeJailBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class InterNationsTypeJailExtension extends Extension
{
    /** @param mixed[] $configs */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('type_jail.xml');

        $config = $this->processConfiguration(new Configuration(), $configs);

        $isEnabled = static::isEnabled($config['enabled'], $container->getParameter('kernel.debug'));

        $factory = $isEnabled ? $config['factory'] : 'null';
        $factoryParameter = '%inter_nations.type_jail.factory.' . $factory . '_factory.class%';
        $container->setParameter('inter_nations.type_jail.factory.class', $factoryParameter);
        $container->setParameter('inter_nations.type_jail.types', $isEnabled ? $config['types'] : []);
    }

    private static function isEnabled(?bool $enabled, bool $debug): bool
    {
        return $enabled === null ? $debug : $enabled;
    }
}
