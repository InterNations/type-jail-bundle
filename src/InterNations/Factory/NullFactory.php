<?php
namespace InterNations\Bundle\TypeJailBundle\Factory;

use InterNations\Component\TypeJail\Factory\JailFactoryInterface;

class NullFactory implements JailFactoryInterface
{
    /**
     * @param object $instance
     * @return object
     */
    public function createInstanceJail($instance, string $class)
    {
        return $instance;
    }

    /**
     * @param iterable|object[] $instanceAggregate
     * @return array|object[]
     */
    public function createAggregateJail(iterable $instanceAggregate, string $class): array
    {
        return $instanceAggregate;
    }
}
