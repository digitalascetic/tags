<?php

namespace DigitalAscetic\TagsBundle\Service;

use DigitalAscetic\TagsBundle\Model\ITag;
use DigitalAscetic\TagsBundle\Model\ITaggable;

interface TagManagerInterface
{
    /**
     * @param ITaggable $taggable
     * @param Itag[] $tags
     */
    public function packTags(ITaggable $taggable, array $tags): void;

    /**
     * @param ITaggable $taggable
     * @param Itag[] $tags
     */
    public function unPackTags(ITaggable $taggable, array $tags): void;
}