<?php

namespace DigitalAscetic\TagsBundle\Service;

use DigitalAscetic\TagsBundle\Entity\TagsRelationship;
use DigitalAscetic\TagsBundle\Model\ITag;
use DigitalAscetic\TagsBundle\Model\ITaggable;
use DigitalAscetic\TagsBundle\Model\TaggableQueryResult;
use DigitalAscetic\TagsBundle\Model\TagQueryResult;
use Doctrine\ORM\EntityManagerInterface;

class TagManager implements TagManagerInterface
{
    const SERVICE_NAME = 'ascetic.tags.manager';

    /** @var EntityManagerInterface */
    private $em;

    /** @var array */
    private $config;

    /**
     * @param EntityManagerInterface $em
     * @param array $config
     */
    public function __construct(EntityManagerInterface $em, array $config)
    {
        $this->em = $em;
        $this->config = $config;
    }

    public function packTags(ITaggable $taggable, array $tags): void
    {
        foreach ($tags as $tag) {
            $taggable->addTag($tag);

            if ($this->isTagRelationshipEnabled()) {
                $this->addTagRelationship($taggable, $tag);
            }
        }

        $this->em->persist($taggable);
        $this->em->flush();
    }

    public function unPackTags(ITaggable $taggable, array $tags): void
    {
        foreach ($tags as $tag) {
            $taggable->removeTag($tag);

            if ($this->isTagRelationshipEnabled()) {
                $this->removeTagRelationship($taggable, $tag);
            }
        }

        $this->em->persist($taggable);
        $this->em->flush();
    }

    public function findByTag(ITag $tag, string $category = null): TagQueryResult
    {
        if (!$this->isTagRelationshipEnabled()) {
            throw new \Exception('Option tags_relations_indexation must be enabled to allow findByTag method.');
        }

        $options = ['tag' => $tag];

        if (isset($category)) {
            $options['objectClass'] = $category;
        }

        /** @var TagsRelationship[] $tagsRelationship */
        $tagsRelationship = $this->em->getRepository(TagsRelationship::class)->findBy($options);

        /** @var TagQueryResult[] $taggableEntities */
        $tagQueryResult = new TagQueryResult(count($tagsRelationship));

        foreach ($tagsRelationship as $tagRel) {
            $tagQueryResult->addResult(new TaggableQueryResult($tagRel->getObjectId(), $tagRel->getObjectClass()));
        }

        return $tagQueryResult;
    }

    private function addTagRelationship(ITaggable $taggable, ITag $tag)
    {
        if (!$this->hasTagRelationship($taggable, $tag)) {
            $tagRelationship = new TagsRelationship($tag, $taggable->getId(), $this->getClassName($taggable));
            $this->em->persist($tagRelationship);
            $this->em->flush();
        }
    }

    private function removeTagRelationship(ITaggable $taggable, ITag $tag)
    {
        if ($this->hasTagRelationship($taggable, $tag)) {
            $className = $this->getClassName($taggable);

            $tagRelationship = $this->em->getRepository(TagsRelationship::class)->findOneBy(
                ['tag' => $tag, 'objectClass' => $className, 'objectId' => $taggable->getId()]
            );

            $this->em->remove($tagRelationship);
            $this->em->flush();
        }
    }

    private function hasTagRelationship(ITaggable $taggable, ITag $tag): bool
    {
        $className = $this->getClassName($taggable);

        $tagRelationship = $this->em->getRepository(TagsRelationship::class)->findOneBy(
            ['tag' => $tag, 'objectClass' => $className, 'objectId' => $taggable->getId()]
        );

        return !is_null($tagRelationship);
    }

    private function getClassName($entity)
    {
        return $this->em->getMetadataFactory()->getMetadataFor(get_class($entity))->getName();
    }

    private function isTagRelationshipEnabled(): bool
    {
        return $this->config['enabled'];
    }
}