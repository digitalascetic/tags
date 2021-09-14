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

    public function getTags(): array
    {
        if (is_null($this->tags)) {
            return [];
        }

        return json_decode($this->tags, true);
    }


    public function hasTag(ITag $tag): bool
    {
        $tags = $this->getTags();

        if (empty($tags)) {
            return false;
        }

        return in_array($tag->getId(), $tags);
    }

    public function addTag(ITag $tag): void
    {
        $tags = $this->getTags();

        if (!$this->hasTag($tag)) {
            array_push($tags, $tag->getId());
        }

        $this->tags = json_encode($tags);
    }

    public function removeTag(ITag $tag): void
    {
        $tags = $this->getTags();

        if ($this->hasTag($tag)) {
            $tagIndex = array_search($tag->getId(), $tags);
            unset($tags[$tagIndex]);
        }

        $this->tags = json_encode($tags);
    }
}