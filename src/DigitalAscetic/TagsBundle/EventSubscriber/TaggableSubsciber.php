<?php

namespace DigitalAscetic\TagsBundle\EventSubscriber;

use DigitalAscetic\TagsBundle\Model\ITag;
use DigitalAscetic\TagsBundle\Model\ITaggable;
use DigitalAscetic\TagsBundle\Model\ITagRelationship;
use DigitalAscetic\TagsBundle\Test\Entity\Tag;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;

class TaggableSubsciber implements EventSubscriber
{
    const SERVICE_NAME = 'ascetic.tags.taggable.subscriber';

    public function getSubscribedEvents()
    {
        return array(
            Events::postPersist,
            Events::preRemove,
            Events::onFlush,
        );
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        if ($this->isTaggable($args->getEntity())) {
            $em = $args->getEntityManager();
            $uow = $em->getUnitOfWork();

            /** @var ITaggable $taggable */
            $taggable = $args->getEntity();
            $tags = $taggable->getTags();

            foreach ($tags as $tag) {
                /** @var ITag $tagEntity */
                $tagEntity = $uow->createEntity(Tag::class, ['id' => $tag]);
                $tagRelationship = $this->createTagRelationship($tagEntity, $taggable);
                $em->persist($tagRelationship);
                $em->flush();
            }
        }
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        if ($this->isTaggable($args->getEntity())) {
            $em = $args->getEntityManager();
            /** @var ITaggable $taggable */
            $taggable = $args->getEntity();
            $this->removeTagRelationship($taggable, $em);
        }
    }

    public function onFlush(OnFlushEventArgs $args)
    {
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            /** @var ITaggable $entity */
            if ($this->isTaggable($entity)) {
                $this->syncTags($entity, $em);
            }
        }

        foreach ($uow->getScheduledEntityDeletions() as $entity) {
            /** @var ITaggable $entity */
            if ($this->isTaggable($entity)) {
                $this->syncTags($entity, $em);
            }
        }
    }

    private function syncTags(ITaggable $taggable, EntityManagerInterface $em)
    {
        $uow = $em->getUnitOfWork();
        $changeset = $uow->getEntityChangeSet($taggable);

        if (array_key_exists('tags', $changeset)) {
            $changes = $changeset['tags'];

            $oldTagsValue = array_key_exists(0, $changes) ? $changes[0] : null;
            $newTagsValue = array_key_exists(1, $changes) ? $changes[1] : null;

            if ($oldTagsValue != $newTagsValue) {
                $this->removeTagRelationship($taggable, $em);

                $newTags = json_decode($newTagsValue, true);

                if ($newTags) {
                    foreach ($newTags as $tag) {
                        /** @var ITag $tagEntity */
                        $tagEntity = $uow->createEntity(Tag::class, ['id' => $tag]);
                        $tagRelationship = $this->createTagRelationship($tagEntity, $taggable);

                        $em->persist($tagRelationship);
                        $meta = $em->getClassMetadata($taggable->getEntityRelationshipClass());

                        if ($uow->isInIdentityMap($tagRelationship)) {
                            $uow->recomputeSingleEntityChangeSet($meta, $tagRelationship);
                        } else {
                            $em->persist($tagRelationship);
                            $uow->computeChangeSet($meta, $tagRelationship);
                        }
                    }
                }
            }
        }
    }

    private function removeTagRelationship(ITaggable $taggable, EntityManagerInterface $em)
    {
        $relatedObjectProperty = call_user_func(
            $taggable->getEntityRelationshipClass().'::getRelatedObjectPropertyName'
        );
        $dqlDelete = "DELETE FROM ".$taggable->getEntityRelationshipClass(
            )." tr WHERE tr.".$relatedObjectProperty." = ".$taggable->getId();

        $em->createQuery($dqlDelete)->execute();
    }

    private function createTagRelationship(ITag $tag, ITaggable $taggable): ITagRelationship
    {
        $refClass = new \ReflectionClass($taggable->getEntityRelationshipClass());

        /** @var ITagRelationship $tagRelationship */
        $tagRelationship = $refClass->newInstanceWithoutConstructor();
        $tagRelationship->setTag($tag);
        $tagRelationship->setRelatedObject($taggable);

        return $tagRelationship;
    }

    private function isTaggable($entity)
    {
        return $entity instanceof ITaggable;
    }
}