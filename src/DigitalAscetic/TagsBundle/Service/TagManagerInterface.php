<?php

namespace DigitalAscetic\TagsBundle\Service;

use DigitalAscetic\TagsBundle\Model\ITag;
use DigitalAscetic\TagsBundle\Model\ITaggable;
use DigitalAscetic\TagsBundle\Model\TagQueryResult;

interface TagManagerInterface
{
    /**
     * Add tag(s) to entity taggable
     *
     * @param ITaggable $taggable
     * @param ITag[] $tags
     * @param bool $indexed
     */
    public function packTags(ITaggable $taggable, array $tags, bool $indexed = true): void;

    /**
     * Remove tag(s) from entity taggable
     *
     * @param ITaggable $taggable
     * @param ITag[] $tags
     * @param bool $indexed
     */
    public function unPackTags(ITaggable $taggable, array $tags, bool $indexed = true): void;

    /**
     * Find ITaggable entities that have a ITag related.
     *
     * @param ITag $tag
     * @param string|null $category
     * @return TagQueryResult
     */
    public function findByTag(ITag $tag, string $category = null): TagQueryResult;
}