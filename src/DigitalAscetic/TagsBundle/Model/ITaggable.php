<?php
/**
 * Created by IntelliJ IDEA.
 * User: martino
 * Date: 2019-02-09
 * Time: 09:42
 */

namespace DigitalAscetic\TagsBundle\Model;


interface ITaggable
{
    public function getId();

    public function getIdTags(): ?array;

    public function addTag(ITag $tag): void;

    public function removeTag(ITag $tag): void;

    public function getEntityRelationshipClass(): string;
}