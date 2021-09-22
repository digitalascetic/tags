<?php

namespace DigitalAscetic\TagsBundle\DependencyInjection;

use DigitalAscetic\TagsBundle\EventSubscriber\TaggableSubsciber;
use DigitalAscetic\TagsBundle\EventSubscriber\TagRelationshipMapListener;
use DigitalAscetic\TagsBundle\Service\TagService;
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
            $taggableSubscriber = new Definition(TaggableSubsciber::class);
            $taggableSubscriber->addArgument($config);
            $taggableSubscriber->addTag('doctrine.event_subscriber');
            $container->setDefinition(TaggableSubsciber::SERVICE_NAME, $taggableSubscriber);
            $container->setAlias(TaggableSubsciber::class, TaggableSubsciber::SERVICE_NAME);

            $tagService = new Definition(TagService::class);
            $container->setDefinition(TagService::SERVICE_NAME, $tagService);
            $container->setAlias(TagService::class, TagService::SERVICE_NAME);

            $tagRelationshipListener = new Definition(TagRelationshipMapListener::class);
            $tagRelationshipListener->addArgument(new Reference(TagService::SERVICE_NAME));
            $tagRelationshipListener->addTag('doctrine.event_subscriber');
            $container->setDefinition(TagRelationshipMapListener::class, $tagRelationshipListener);
        }
    }

    public function prepend(ContainerBuilder $container)
    {
    }
}