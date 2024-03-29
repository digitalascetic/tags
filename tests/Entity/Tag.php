<?php

namespace DigitalAscetic\TagsBundle\Test\Entity;

use DigitalAscetic\TagsBundle\Model\ITag;
use DigitalAscetic\TagsBundle\Entity\TagTrait;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="tags")
 * @ORM\Entity()
 */
class Tag implements ITag
{
    use TagTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @param string $tagName
     * @param string|null $category
     */
    public function __construct(string $tagName, string $category = null)
    {
        $this->tagName = $tagName;
        $this->category = $category;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}