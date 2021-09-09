<?php
/**
 * Created by IntelliJ IDEA.
 * User: martino
 * Date: 2019-02-09
 * Time: 09:42
 */

namespace DigitalAscetic\BaseTagBundle\Entity;


interface ITag
{
    public function getTagName(): string;

    public function getTagHexColor(): int;

    public function getObjectClass(): ?string;
}