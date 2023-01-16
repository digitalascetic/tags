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
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CountryTag
 * @package DigitalAscetic\BaseEntityBundle\Test\Entity
 *
 * @ORM\Table(name="taggable")
 * @ORM\Entity()
 */
#[ORM\Table(name: "taggable")]
#[ORM\Entity]
class TaggableEntity implements ITaggable
{
    use TaggableTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    protected ?int $id = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntityRelationshipClass(): string
    {
        return TaggableRelationship::class;
    }
}
