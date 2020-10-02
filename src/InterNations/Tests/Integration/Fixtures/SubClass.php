<?php
namespace InterNations\Bundle\TypeJailBundle\Tests\Integration\Fixtures;

class SubClass extends Clazz
{
    public function subClassMethod(): string
    {
        return __FUNCTION__;
    }
}
