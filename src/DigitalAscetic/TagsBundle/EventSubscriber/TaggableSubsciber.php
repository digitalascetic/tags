<?php

namespace DigitalAscetic\TagsBundle\EventSubscriber;

use DigitalAscetic\TagsBundle\Model\ITaggable;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;

class TaggableSubsciber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return array(
            Events::onFlush,
        );
    }

    public function onFlush(OnFlushEventArgs $args)
    {
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            /** @var ITaggable $entity */
            if ($this->isTaggable($entity)) {
                $tag = $entity->getTags();
            }
        }
    }

    private function isTaggable($entity)
    {
        return $entity instanceof ITaggable;
    }
}