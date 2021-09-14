<?php

namespace DigitalAscetic\TagsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait TagTrait
{
    /**
     * @var string
     *
     * @ORM\Column(name="tag_name", type="string", nullable=false)
     */
    protected $tagName;

    /**
     * @var string
     *
     * @ORM\Column(name="tag_hex_color", type="string", nullable=false)
     */
    protected $tagHexColor;

    /**
     * @var string|null
     *
     * @ORM\Column(name="category", type="string", nullable=true)
     */
    protected $category;

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
     * @return string
     */
    public function getTagHexColor(): string
    {
        return $this->tagHexColor;
    }

    /**
     * @param string $tagHexColor
     */
    public function setTagHexColor(string $tagHexColor): void
    {
        $this->tagHexColor = $tagHexColor;
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