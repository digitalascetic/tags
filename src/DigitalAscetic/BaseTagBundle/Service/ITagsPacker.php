<?php
/**
 * Created by IntelliJ IDEA.
 * User: martino
 * Date: 2019-02-09
 * Time: 10:01
 */

namespace DigitalAscetic\BaseTagBundle\Service;


use DigitalAscetic\BaseTagBundle\Entity\ITag;

interface ITagsPacker
{

    /**
     * @return ITag[]
     */
    public function unPackTags($entity, string $tagPack, string $tagClass): array ;


    /**
     * @param ITag[] $tags
     * @return string
     */
    public function packTags($entity, array $tags, string $tagClass): string ;

}