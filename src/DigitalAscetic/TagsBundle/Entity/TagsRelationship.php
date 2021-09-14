<?php

namespace DigitalAscetic\TagsBundle\Entity;

use DigitalAscetic\TagsBundle\Model\ITag;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="tags_relatonship")
 * @ORM\Entity()
 */
class TagsRelationship
{
    /**
     * @var ITag
     */
    private $tag;

    /**
     * @var int
     * @ORM\Column(name="object_id", type="integer", nullable=false)
     */
    private $objectId;

    /**
     * @var string
     * @ORM\Column(name="object_id", type="string", nullable=false)
     */
    private $objectClass;

    /**
     * @param ITag $tag
     * @param int $objectId
     * @param string $objectClass
     */
    public function __construct(ITag $tag, int $objectId, string $objectClass)
    {
        $this->tag = $tag;
        $this->objectId = $objectId;
        $this->objectClass = $objectClass;
    }

    /**
     * @return ITag
     */
    public function getTag(): ITag
    {
        return $this->tag;
    }

    /**
     * @return int
     */
    public function getObjectId(): int
    {
        return $this->objectId;
    }

    /**
     * @return string
     */
    public function getObjectClass(): string
    {
        return $this->objectClass;
    }
}