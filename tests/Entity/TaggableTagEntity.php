<?php
/**
 * Created by IntelliJ IDEA.
 * User: martino
 * Date: 2019-02-09
 * Time: 09:49
 */

namespace DigitalAscetic\TagsBundle\Test\Entity;


use DigitalAscetic\TagsBundle\Entity\TaggableTrait;
use DigitalAscetic\TagsBundle\Model\ITaggable;
use DigitalAscetic\TagsBundle\Model\ITaggableTag;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CountryTag
 * @package DigitalAscetic\BaseEntityBundle\Test\Entity
 *
 * @ORM\Table(name="taggable_tag")
 * @ORM\Entity()
 */
class TaggableTagEntity implements ITaggable, ITaggableTag
{
    use TaggableTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getEntityRelationshipClass(): string
    {
        return TaggableTagRelationship::class;
    }

    public function getTagClass(): string
    {
        return TagCustom::class;
    }
}