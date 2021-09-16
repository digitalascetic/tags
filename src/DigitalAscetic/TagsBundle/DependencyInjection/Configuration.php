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
        ->end();

        return $treeBuilder;
    }

}