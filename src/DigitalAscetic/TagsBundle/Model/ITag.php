<?php
/**
 * Created by IntelliJ IDEA.
 * User: martino
 * Date: 2019-02-09
 * Time: 09:42
 */

namespace DigitalAscetic\TagsBundle\Model;


interface ITag
{
    public function getId(): int;

    public function getTagName(): string;

    public function getCategory(): ?string;
}