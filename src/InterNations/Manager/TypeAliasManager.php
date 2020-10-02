<?php
namespace InterNations\Bundle\TypeJailBundle\Manager;

final class TypeAliasManager
{
    /** @var array */
    private array $typeMap;

    /** @param string[] $typeMap */
    public function __construct(array $typeMap)
    {
        $this->typeMap = $typeMap;
    }

    public function getType(string $alias): ?string
    {
        return $this->typeMap[$alias] ?? null;
    }
}
