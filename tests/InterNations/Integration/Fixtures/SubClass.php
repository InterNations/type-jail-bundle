<?php
namespace InterNations\Bundle\TypeJailBundle\Integration\Fixtures;

class SubClass extends Clazz
{
    public function subClassMethod(): string
    {
        return __FUNCTION__;
    }
}
