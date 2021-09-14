<?php

namespace DigitalAscetic\TagsBundle\DependencyInjection;

use DigitalAscetic\TagsBundle\EventSubscriber\TagsRelationshipMappingSubscriber;
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
            if ($config['tags_relations_indexed'] && $config['tags_relations_indexed']['enabled']) {
                $tagRelationshipMapping = new Definition(TagsRelationshipMappingSubscriber::class);
                $tagRelationshipMapping->addArgument($config['tags_relations_indexed']['tag']);
                $tagRelationshipMapping->addTag('doctrine.event_subscriber');
                $container->setDefinition(TagsRelationshipMappingSubscriber::SERVICE_NAME, $tagRelationshipMapping);
            }

            $tagManager = new Definition(TagManager::class);
            $tagManager->addArgument(new Reference('doctrine.orm.entity_manager'));
            $tagManager->addArgument($config['tags_relations_indexed']);
            $container->setDefinition(TagManager::SERVICE_NAME, $tagManager);
            $container->setAlias(TagManagerInterface::class, TagManager::class);
        }
    }

    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');
        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);

        if ($config['enabled']) {
            if ($config['tags_relations_indexed'] && $config['tags_relations_indexed']['enabled']) {
                if (!isset($bundles['DoctrineBundle'])) {
                    throw new InvalidConfigurationException(
                        "You must register DoctrineBundle in AppKernel in order to work with DigitalAsceticTagsBundle"
                    );
                }

                $doctrineConfig = array(
                    'orm' => array(
                        'mappings' => array(
                            'asceticbasetags' => array(
                                'type' => 'annotation',
                                'is_bundle' => false,
                                'prefix' => 'DigitalAscetic\TagsBundle',
                                'dir' => $config['tags_relations_indexed']['mapping_dir'],
                                'alias' => 'DigitalAsceticTags',
                            ),
                        ),
                    ),
                );

                $container->prependExtensionConfig('doctrine', $doctrineConfig);
            }
        }
    }
}