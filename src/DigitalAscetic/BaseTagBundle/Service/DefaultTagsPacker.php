<?php
/**
 * Created by IntelliJ IDEA.
 * User: martino
 * Date: 2019-02-09
 * Time: 10:06
 */

namespace DigitalAscetic\BaseTagBundle\Service;


use DigitalAscetic\BaseTagBundle\Entity\ITag;

class DefaultTagsPacker implements ITagsPacker
{

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @return ITag[]
     */
    public function unPackTags($entity, string $tagPack, string $tagClass): array
    {

    }

    /**
     * @param ITag[] $tags
     * @return string
     */
    public function packTags($entity, array $tags, string $tagClass): string
    {
        // TODO: Implement packTags() method.
    }
}