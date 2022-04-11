<?php
namespace InterNations\Bundle\TypeJailBundle\Factory;

use InterNations\Component\TypeJail\Factory\JailFactoryInterface;

final class NullFactory implements JailFactoryInterface
{
    /** @no-named-arguments */
    public function createInstanceJail(object $instance, string $class): object
    {
        return $instance;
    }

    /**
     * @param iterable|object[] $instanceAggregate
     * @return array|object[]
     * @no-named-arguments
     */
    public function createAggregateJail(iterable $instanceAggregate, string $class): iterable
    {
        return $instanceAggregate;
    }
}
