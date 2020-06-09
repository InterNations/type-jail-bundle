<?php
namespace InterNations\Bundle\TypeJailBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('inter_nations_type_jail');

        $treeBuilder->getRootNode()
            ->children()
                ->booleanNode('enabled')->defaultNull()->end()
                ->scalarNode('factory')->defaultValue('jail')->end()
                ->arrayNode('types')
                    ->useAttributeAsKey('key')->prototype('scalar');

        return $treeBuilder;
    }
}
