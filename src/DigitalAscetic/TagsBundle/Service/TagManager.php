<?php

namespace DigitalAscetic\TagsBundle\Service;

use DigitalAscetic\TagsBundle\Model\ITaggable;
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
        }

        $this->em->persist($taggable);
        $this->em->flush();
    }

    public function unPackTags(ITaggable $taggable, array $tags): void
    {
        foreach ($tags as $tag) {
            $taggable->removeTag($tag);
        }

        $this->em->persist($taggable);
        $this->em->flush();
    }
}