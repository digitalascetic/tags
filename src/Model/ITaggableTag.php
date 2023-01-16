<?php

namespace DigitalAscetic\TagsBundle\Model;

interface ITaggableTag
{
    public function getTagClass(): string;
}