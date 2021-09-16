<?php

namespace DigitalAscetic\TagsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('digital_ascetic_tags');

        $rootNode
            ->canBeEnabled()
            ->children()
                ->scalarNode('default_tag')->isRequired()->end()
                ->arrayNode('taggables')->isRequired()
                ->useAttributeAsKey('name')
                ->arrayPrototype()
                ->children()
                    ->scalarNode('relationship')->isRequired()->end()
                    ->scalarNode('tag')->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }

}