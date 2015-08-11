<?php
namespace InterNations\Bundle\TypeJailBundle\View\Twig\Extension;

use InterNations\Bundle\TypeJailBundle\Manager\TypeAliasManager;
use InterNations\Component\TypeJail\Factory\JailFactoryInterface;
use Twig_Extension as Extension;
use Twig_SimpleFunction as SimpleFunction;

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

    public function getFunctions()
    {
        return [
            new SimpleFunction('jail', [$this, 'createInstanceJail']),
            new SimpleFunction('jail_or_null', [$this, 'createInstanceJailOrNull']),
            new SimpleFunction('jail_aggregate', [$this, 'createAggregateJail']),
        ];
    }

    public function createInstanceJail($instance, $typeOrAlias)
    {
        $type = $this->typeAliasManager->getType($typeOrAlias) ?: $typeOrAlias;

        return $this->jailFactory->createInstanceJail($instance, $type);
    }

    public function createInstanceJailOrNull($instance, $typeOrAlias)
    {
        if ($instance === null) {
            return null;
        }

        return $this->createInstanceJail($instance, $typeOrAlias);
    }

    public function createAggregateJail($aggregate, $typeOrAlias)
    {
        $type = $this->typeAliasManager->getType($typeOrAlias) ?: $typeOrAlias;


        return $this->jailFactory->createAggregateJail($aggregate, $type);
    }

    public function getName()
    {
        return 'jail';
    }
}
