<?php

namespace DigitalAscetic\TagsBundle\DependencyInjection;

use DigitalAscetic\TagsBundle\Service\TagManager;
use DigitalAscetic\TagsBundle\Service\TagManagerInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Reference;

class DigitalAsceticTagsExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        if ($config['enabled']) {
            $tagManager = new Definition(TagManager::class);
            $tagManager->addArgument(new Reference('doctrine.orm.entity_manager'));
            $container->setDefinition(TagManager::SERVICE_NAME, $tagManager);
            $container->setAlias(TagManager::class, TagManager::SERVICE_NAME);
            $container->setAlias(TagManagerInterface::class, TagManager::class);
        }
    }

    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');
        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);

        if ($config['enabled']) {


        }
    }
}