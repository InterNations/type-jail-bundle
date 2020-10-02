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

    public function __construct(JailFactoryInterface $jailFactory, TypeAliasManager $typeAliasManager)
    {
        $this->jailFactory = $jailFactory;
        $this->typeAliasManager = $typeAliasManager;
    }

    /** @return TwigFunction[] */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('jail', [$this, 'createInstanceJail']),
            new TwigFunction('jail_or_null', [$this, 'createInstanceJailOrNull']),
            new TwigFunction('jail_aggregate', [$this, 'createAggregateJail']),
        ];
    }

    public function createInstanceJail(object $instance, string $typeOrAlias): object
    {
        $type = $this->typeAliasManager->getType($typeOrAlias) ?: $typeOrAlias;

        return $this->jailFactory->createInstanceJail($instance, $type);
    }

    public function createInstanceJailOrNull(?object $instance, string $typeOrAlias): ?object
    {
        if ($instance === null) {
            return null;
        }

        return $this->createInstanceJail($instance, $typeOrAlias);
    }

    public function createAggregateJail(iterable $aggregate, string $typeOrAlias): iterable
    {
        $type = $this->typeAliasManager->getType($typeOrAlias) ?: $typeOrAlias;

        return iterator_to_array($this->jailFactory->createAggregateJail($aggregate, $type));
    }

    public function getName(): string
    {
        return 'jail';
    }
}
