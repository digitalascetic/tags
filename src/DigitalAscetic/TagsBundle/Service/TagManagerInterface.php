<?php

namespace DigitalAscetic\TagsBundle\Service;

use DigitalAscetic\TagsBundle\Model\ITag;
use DigitalAscetic\TagsBundle\Model\ITaggable;
use DigitalAscetic\TagsBundle\Model\TagQueryResult;

interface TagManagerInterface
{
    /**
     * @param ITaggable $taggable
     * @param ITag[] $tags
     */
    public function packTags(ITaggable $taggable, array $tags): void;

    /**
     * @param ITaggable $taggable
     * @param ITag[] $tags
     */
    public function unPackTags(ITaggable $taggable, array $tags): void;

    /**
     * @param ITag $tag
     * @param string|null $category
     * @return TagQueryResult[]
     */
    public function findByTag(ITag $tag, string $category = null): array;
}