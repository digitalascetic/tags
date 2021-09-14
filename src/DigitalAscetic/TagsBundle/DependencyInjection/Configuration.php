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
                ->arrayNode('tags_relations_indexation')
                    ->canBeEnabled()
                    ->children()
                        ->scalarNode('mapping_dir')->defaultValue('%kernel.root_dir%/../vendor/digitalascetic/tags/src/DigitalAscetic/TagsBundle/Entity')->end()
                        ->arrayNode('tag')
                            ->children()
                                ->scalarNode('class_name')->isRequired()->end()
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