<?php

namespace DigitalAscetic\BaseTagBundle\Test\Entity;

use DigitalAscetic\BaseTagBundle\Entity\ITag;
use Doctrine\ORM\Mapping as ORM;

class Tags implements ITag
{
    /**
     * @var string
     *
     * @ORM\Column(name="tag_name", type="string", nullable=false)
     */
    private $tagName;

    /**
     * @var string
     *
     * @ORM\Column(name="tag_hex_color", type="string", nullable=false)
     */
    private $tagHexColor;

    /**
     * @var string
     *
     * @ORM\Column(name="object_class", type="string", nullable=true)
     */
    private $objectClass;

    /**
     * @param string $tagName
     * @param string $tagHexColor
     * @param string|null $objectClass
     */
    public function __construct(string $tagName, string $tagHexColor, ?string $objectClass)
    {
        $this->tagName = $tagName;
        $this->tagHexColor = $tagHexColor;
        $this->objectClass = $objectClass;
    }

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
    public function getObjectClass(): ?string
    {
        return $this->objectClass;
    }
}