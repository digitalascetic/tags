<?php

namespace DigitalAscetic\TagsBundle\DependencyInjection;

use DigitalAscetic\TagsBundle\EventSubscriber\TaggableSubscriber;
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
            $taggableSubscriber = new Definition(TaggableSubscriber::class);
            $taggableSubscriber->addArgument($config);
            $taggableSubscriber->addTag('doctrine.event_subscriber');
            $container->setDefinition(TaggableSubscriber::SERVICE_NAME, $taggableSubscriber);
            $container->setAlias(TaggableSubscriber::class, TaggableSubscriber::SERVICE_NAME);
        }
    }

    public function prepend(ContainerBuilder $container)
    {
    }
}
