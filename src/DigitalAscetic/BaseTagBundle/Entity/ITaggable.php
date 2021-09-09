<?php
/**
 * Created by IntelliJ IDEA.
 * User: martino
 * Date: 2019-02-09
 * Time: 09:42
 */

namespace DigitalAscetic\BaseTagBundle\Entity;


interface ITaggable
{
    public function getTags(): ?string;

    public function hasTag(int $tag): bool;

    public function addTag(int $tag): void;

    public function removeTag(int $tag): void;
}