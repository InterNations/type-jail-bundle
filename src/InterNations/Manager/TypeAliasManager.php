<?php
namespace InterNations\Bundle\TypeJailBundle\Manager;

final class TypeAliasManager
{
    /** @var array */
    private array $typeMap;

    /**
     * @param string[] $typeMap
     * @no-named-arguments
     */
    public function __construct(array $typeMap)
    {
        $this->typeMap = $typeMap;
    }

    /** @no-named-arguments */
    public function getType(string $alias): ?string
    {
        return $this->typeMap[$alias] ?? null;
    }
}
