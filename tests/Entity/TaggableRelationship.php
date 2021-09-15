<?php
/**
 * Created by IntelliJ IDEA.
 * User: martino
 * Date: 2019-02-09
 * Time: 09:49
 */

namespace DigitalAscetic\TagsBundle\Test\Entity;


use DigitalAscetic\TagsBundle\Model\ITag;
use DigitalAscetic\TagsBundle\Model\ITaggable;
use DigitalAscetic\TagsBundle\Model\ITagRelationship;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CountryTag
 * @package DigitalAscetic\BaseEntityBundle\Test\Entity
 *
 * @ORM\Table(name="taggable_relationship")
 * @ORM\Entity()
 */
class TaggableRelationship implements ITagRelationship
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Tag $tag
     * @ORM\ManyToOne (targetEntity="DigitalAscetic\TagsBundle\Test\Entity\Tag")
     * @ORM\JoinColumn(name="tag_id", referencedColumnName="id", nullable=false)
     */
    private $tag;

    /**
     * @var TaggableEntity $objectRelated
     * @ORM\ManyToOne (targetEntity="DigitalAscetic\TagsBundle\Test\Entity\TaggableEntity")
     * @ORM\JoinColumn(name="taggable_id", referencedColumnName="id", nullable=false)
     */
    private $objectRelated;

    /**
     * @param Tag $tag
     * @param TaggableEntity $objectRelated
     */
    public function __construct(Tag $tag, TaggableEntity $objectRelated)
    {
        $this->tag = $tag;
        $this->objectRelated = $objectRelated;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getTag(): ITag
    {
        return $this->tag;
    }

    public function getObjectRelated(): ITaggable
    {
        return $this->objectRelated;
    }

    /**
     * @param Tag $tag
     */
    public function setTag(ITag $tag): void
    {
        $this->tag = $tag;
    }

    /**
     * @param TaggableEntity $objectRelated
     */
    public function setObjectRelated(ITaggable $objectRelated): void
    {
        $this->objectRelated = $objectRelated;
    }

}