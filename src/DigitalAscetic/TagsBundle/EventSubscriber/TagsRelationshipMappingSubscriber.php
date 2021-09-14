<?php

namespace DigitalAscetic\TagsBundle\EventSubscriber;

use DigitalAscetic\TagsBundle\Entity\TagsRelationship;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;

class TagsRelationshipMappingSubscriber implements EventSubscriber
{
    const SERVICE_NAME = 'ascetic.tags.relationship_mapping.subscriber';

    /** @var array */
    private $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }


    public function getSubscribedEvents()
    {
        return array(
            Events::loadClassMetadata,
        );
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        /** @var ClassMetadata $metadata */
        $metadata = $eventArgs->getClassMetadata();

        $reflectionClass = $metadata->getReflectionClass();

        if ($reflectionClass->getName() == TagsRelationship::class) {
            if (!$metadata->hasAssociation('tag')) {
                $metadata->mapManyToOne(
                    array(
                        'targetEntity' => $this->config['class_name'],
                        'fieldName' => 'tag',
                        'joinColumns' => array(
                            array(
                                'name' => 'tag_id',
                                'referencedColumnName' => $this->config['property_id'],
                                'nullable' => false,
                            ),
                        ),
                    )
                );
            }
        }
    }
}