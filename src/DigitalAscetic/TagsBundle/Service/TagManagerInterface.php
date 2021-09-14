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
     * @param bool $indexed
     */
    public function packTags(ITaggable $taggable, array $tags, bool $indexed = false): void;

    /**
     * @param ITaggable $taggable
     * @param ITag[] $tags
     * @param bool $indexed
     */
    public function unPackTags(ITaggable $taggable, array $tags, bool $indexed = false): void;

    /**
     * @param ITag $tag
     * @param string|null $category
     * @return TagQueryResult
     */
    public function findByTag(ITag $tag, string $category = null): TagQueryResult;
}