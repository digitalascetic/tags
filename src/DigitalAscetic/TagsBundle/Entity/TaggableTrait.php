<?php

namespace DigitalAscetic\TagsBundle\Entity;

use DigitalAscetic\TagsBundle\Model\ITag;
use Doctrine\ORM\Mapping as ORM;

trait TaggableTrait
{
    /**
     * @var string|null
     * @ORM\Column(name="tags", type="text", nullable=true)
     */
    private $tags;

    /**
     * @return string[]|null
     */
    public function getTags(): ?array
    {
        return json_decode($this->tags);
    }


    public function hasTag(ITag $tag): bool
    {
        $tags = $this->getTags();

        return array_key_exists($tag->getId(), $tags);
    }

    public function addTag(ITag $tag): void
    {
        $tags = $this->getTags();

        if (!$this->hasTag($tag)) {
            $tags[$tag->getId()] = $tag->getTagName();
        }

        $this->tags = json_encode($tags);
    }

    public function removeTag(ITag $tag): void
    {
        $tags = $this->getTags();

        if ($this->hasTag($tag)) {
            unset($tags[$tag->getId()]);
        }

        $this->tags = json_encode($tags);
    }
}