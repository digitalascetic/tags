<?php

namespace DigitalAscetic\TagsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait TagTrait
{
    /**
     * @var string
     *
     */
    #[ORM\Column(name: "tag_name", type: "string", nullable: false)]
    protected string $tagName;

    /**
     * @var string|null
     *
     */
    #[ORM\Column(name: "category", type: "string", nullable: true)]
    protected ?string $category = null;

    /**
     * @return string
     */
    public function getTagName(): string
    {
        return $this->tagName;
    }

    /**
     * @param string $tagName
     */
    public function setTagName(string $tagName): void
    {
        $this->tagName = $tagName;
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     */
    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }
}
