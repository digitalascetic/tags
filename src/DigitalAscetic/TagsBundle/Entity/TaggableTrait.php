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

    public function addTag(ITag $tag): void
    {
        $tags = $this->getTags();

        if (!in_array($tag->getId(), $this->getTags())) {
            array_push($tags, $tag->getId());
        }

        $this->tags = json_encode($tags);
    }

    public function removeTag(ITag $tag): void
    {
        $tags = $this->getTags();

        if (in_array($tag->getId(), $this->getTags())) {
            $tagIndex = array_search($tag->getId(), $tags);
            unset($tags[$tagIndex]);
        }

        $this->tags = json_encode($tags);
    }
}