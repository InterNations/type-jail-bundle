<?php
namespace InterNations\Bundle\TypeJailBundle\View\Twig\Extension;

use InterNations\Bundle\TypeJailBundle\Manager\TypeAliasManager;
use InterNations\Component\TypeJail\Factory\JailFactoryInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use function iterator_to_array;

class TypeJailExtension extends AbstractExtension
{
    private JailFactoryInterface $jailFactory;
    private TypeAliasManager $typeAliasManager;

    /** @no-named-arguments */
    public function __construct(JailFactoryInterface $jailFactory, TypeAliasManager $typeAliasManager)
    {
        $this->jailFactory = $jailFactory;
        $this->typeAliasManager = $typeAliasManager;
    }

    /**
     * @return TwigFunction[]
     * @no-named-arguments
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('jail', [$this, 'createInstanceJail']),
            new TwigFunction('jail_or_null', [$this, 'createInstanceJailOrNull']),
            new TwigFunction('jail_aggregate', [$this, 'createAggregateJail']),
        ];
    }

    /** @no-named-arguments */
    public function createInstanceJail(object $instance, string $typeOrAlias): object
    {
        $type = $this->typeAliasManager->getType($typeOrAlias) ?: $typeOrAlias;

        return $this->jailFactory->createInstanceJail($instance, $type);
    }

    /** @no-named-arguments */
    public function createInstanceJailOrNull(?object $instance, string $typeOrAlias): ?object
    {
        if ($instance === null) {
            return null;
        }

        return $this->createInstanceJail($instance, $typeOrAlias);
    }

    /**
     * @param object[] $aggregate
     * @return object[]
     * @no-named-arguments
     */
    public function createAggregateJail(iterable $aggregate, string $typeOrAlias): array
    {
        $type = $this->typeAliasManager->getType($typeOrAlias) ?: $typeOrAlias;

        $aggregate = $this->jailFactory->createAggregateJail($aggregate, $type);

        return is_array($aggregate) ? $aggregate : iterator_to_array($aggregate);
    }

    public function getName(): string
    {
        return 'jail';
    }
}
