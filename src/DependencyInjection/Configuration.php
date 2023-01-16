<?php

namespace DigitalAscetic\TagsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('digital_ascetic_tags');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->canBeEnabled()
            ->children()
                ->scalarNode('default_tag')->isRequired()->end()
            ->end()
        ->end();

        return $treeBuilder;
    }

}
