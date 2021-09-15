<?php

namespace DigitalAscetic\TagsBundle\Service;

use DigitalAscetic\TagsBundle\Model\ITag;
use DigitalAscetic\TagsBundle\Model\ITaggable;
use DigitalAscetic\TagsBundle\Model\ITagRelationship;
use DigitalAscetic\TagsBundle\Model\TaggableQueryResult;
use DigitalAscetic\TagsBundle\Model\TagQueryResult;
use Doctrine\ORM\EntityManagerInterface;

class TagManager implements TagManagerInterface
{
    const SERVICE_NAME = 'ascetic.tags.manager';

    /** @var EntityManagerInterface */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function packTags(ITaggable $taggable, array $tags, bool $indexed = true): void
    {
        foreach ($tags as $tag) {
            $taggable->addTag($tag);
            $this->addTagRelationship($taggable, $tag);
        }

        $this->em->persist($taggable);
        $this->em->flush();
    }

    public function unPackTags(ITaggable $taggable, array $tags, bool $indexed = true): void
    {
        foreach ($tags as $tag) {
            $taggable->removeTag($tag);
            $this->removeTagRelationship($taggable, $tag);
        }

        $this->em->persist($taggable);
        $this->em->flush();
    }

    public function findByTag(ITag $tag, string $relationship): TagQueryResult
    {
        $options = ['tag' => $tag];

        if (isset($category)) {
            $options['objectClass'] = $category;
        }

        $results = $this->em->getRepository($relationship)->findBy(['tag' => $tag]);

        $result = new TagQueryResult(count($results));

        return $result;
    }

    private function addTagRelationship(ITaggable $taggable, ITag $tag)
    {
        if (!$this->hasTagRelationship($taggable, $tag)) {
            $refClass = new \ReflectionClass($taggable->getEntityRelationship());

            /** @var ITagRelationship $tagRelationship */
            $tagRelationship = $refClass->newInstanceWithoutConstructor();
            $tagRelationship->setTag($tag);
            $tagRelationship->setObjectRelated($taggable);

            $this->em->persist($tagRelationship);
            $this->em->flush();
        }
    }

    private function removeTagRelationship(ITaggable $taggable, ITag $tag)
    {
        if ($this->hasTagRelationship($taggable, $tag)) {
            $tagRelationship = $this->em->getRepository($taggable->getEntityRelationship())->findOneBy(
                ['tag' => $tag, 'objectRelated' => $taggable]
            );

            $this->em->remove($tagRelationship);
            $this->em->flush();
        }
    }

    private function hasTagRelationship(ITaggable $taggable, ITag $tag): bool
    {
        $tagRelationship = $this->em->getRepository($taggable->getEntityRelationship())->findOneBy(
            ['tag' => $tag, 'objectRelated' => $taggable]
        );

        return !is_null($tagRelationship);
    }
}