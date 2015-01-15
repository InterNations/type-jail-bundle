<?php
namespace InterNations\Bundle\TypeJailBundle\Factory;

use InterNations\Component\TypeJail\Factory\JailFactoryInterface;

class NullFactory implements JailFactoryInterface
{
    public function createInstanceJail($instance, $class)
    {
        return $instance;
    }

    public function createAggregateJail($instanceAggregate, $class)
    {
        return $instanceAggregate;
    }
}
