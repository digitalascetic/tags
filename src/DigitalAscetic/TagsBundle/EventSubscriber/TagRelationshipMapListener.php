<?php

namespace DigitalAscetic\TagsBundle\EventSubscriber;

use DigitalAscetic\TagsBundle\Model\ITagRelationship;
use DigitalAscetic\TagsBundle\Service\TagService;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;

class TagRelationshipMapListener implements EventSubscriber
{
    /** @var TagService */
    private $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::loadClassMetadata,
        ];
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $args)
    {
        /** @var ClassMetadata $metadata */
        $metadata = $args->getClassMetadata();

        if ($this->isTagRelationship($metadata)) {
            $this->tagService->addTagRelationshipClassName($metadata->getName());
        }
    }

    private function isTagRelationship(ClassMetadata $metadata)
    {
        $reflectionClass = $metadata->getReflectionClass();

        return $reflectionClass->isSubclassOf(ITagRelationship::class);
    }
}