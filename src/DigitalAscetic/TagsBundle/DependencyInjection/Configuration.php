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
                ->arrayNode('tag')->isRequired()
                    ->children()
                        ->scalarNode('class_name')->cannotBeEmpty()->end()
                        ->scalarNode('property_id')->defaultValue('id')->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }

}