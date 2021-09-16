<?php

namespace DigitalAscetic\TagsBundle\Model;

interface ITagRelationship
{
    /** @var ITag */
    public function getTag(): ITag;

    /** @var ITaggable */
    public function getRelatedObject(): ITaggable;

    /** @param ITag */
    public function setTag($tag): void;

    /** @param ITaggable */
    public function setRelatedObject(ITaggable $taggable): void;
}