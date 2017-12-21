<?php
namespace InterNations\Bundle\TypeJailBundle\Manager;

class TypeAliasManager
{
    /** @var array */
    private $typeMap;

    /** @param string[] $typeMap */
    public function __construct(array $typeMap)
    {
        $this->typeMap = $typeMap;
    }

    public function getType(string $alias): ?string
    {
        return isset($this->typeMap[$alias]) ? $this->typeMap[$alias] : null;
    }
}
