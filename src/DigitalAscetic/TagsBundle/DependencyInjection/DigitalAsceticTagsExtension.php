<?php

namespace DigitalAscetic\TagsBundle\DependencyInjection;

use DigitalAscetic\TagsBundle\EventSubscriber\TaggableSubsciber;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class DigitalAsceticTagsExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        if ($config['enabled']) {
            $taggableSubscriber = new Definition(TaggableSubsciber::class);
            $taggableSubscriber->addTag('doctrine.event_subscriber');
            $container->setDefinition(TaggableSubsciber::SERVICE_NAME, $taggableSubscriber);
            $container->setAlias(TaggableSubsciber::class, TaggableSubsciber::SERVICE_NAME);
        }
    }

    public function prepend(ContainerBuilder $container)
    {

    }
}