<?php
namespace InterNations\Bundle\TypeJailBundle\View\Twig\Extension;

use InterNations\Bundle\TypeJailBundle\Manager\TypeAliasManager;
use InterNations\Component\TypeJail\Factory\JailFactoryInterface;
use Twig_Extension as Extension;
use Twig\TwigFunction;

class TypeJailExtension extends Extension
{
    /** @var JailFactoryInterface */
    private $jailFactory;

    /** @var TypeAliasManager */
    private $typeAliasManager;

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

    /**
     * @param object $instance
     * @return object
     */
    public function createInstanceJail($instance, string $typeOrAlias)
    {
        $type = $this->typeAliasManager->getType($typeOrAlias) ?: $typeOrAlias;

        return $this->jailFactory->createInstanceJail($instance, $type);
    }

    /**
     * @param object $instance
     * @return null|object
     */
    public function createInstanceJailOrNull($instance, string $typeOrAlias)
    {
        if ($instance === null) {
            return null;
        }

        return $this->createInstanceJail($instance, $typeOrAlias);
    }

    /**
     * @param object[] $aggregate
     * @return object[]
     */
    public function createAggregateJail(iterable $aggregate, string $typeOrAlias): array
    {
        $type = $this->typeAliasManager->getType($typeOrAlias) ?: $typeOrAlias;


        return $this->jailFactory->createAggregateJail($aggregate, $type);
    }

    public function getName(): string
    {
        return 'jail';
    }
}
