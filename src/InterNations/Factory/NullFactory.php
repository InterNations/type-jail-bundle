<?php
namespace InterNations\Bundle\TypeJailBundle\Factory;

use InterNations\Component\TypeJail\Factory\JailFactoryInterface;

final class NullFactory implements JailFactoryInterface
{
    public function createInstanceJail(object $instance, string $class): object
    {
        return $instance;
    }

    /**
     * @param iterable|object[] $instanceAggregate
     * @return array|object[]
     */
    public function createAggregateJail(iterable $instanceAggregate, string $class): iterable
    {
        return $instanceAggregate;
    }
}
