<?php

namespace DigitalAscetic\TagsBundle\Model;

interface ITagRelationship
{
    /** @var ITag */
    public function getTag(): ITag;

    /** @var ITaggable */
    public function getObjectRelated(): ITaggable;

    /** @param ITag */
    public function setTag(ITag $tag): void;

    /** @param ITaggable */
    public function setObjectRelated(ITaggable $taggable): void;
}