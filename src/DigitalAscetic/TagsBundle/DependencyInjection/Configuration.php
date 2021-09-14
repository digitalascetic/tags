<?php

namespace DigitalAscetic\TagsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ascetic_base_tag');

        $rootNode
            ->canBeEnabled()
            ->children()
                ->arrayNode('tags_relations_indexed')
                    ->canBeEnabled()
                    ->children()
                        ->scalarNode('mapping_dir')->defaultValue('%kernel.root_dir%/../vendor/digitalascetic/tags/src/DigitalAscetic/TagsBundle/Entity')->end()
                        ->arrayNode('tag')
                            ->children()
                                ->scalarNode('class_name')->cannotBeEmpty()->end()
                                ->scalarNode('property_id')->defaultValue('id')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }

}