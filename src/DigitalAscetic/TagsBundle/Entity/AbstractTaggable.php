<?php

namespace DigitalAscetic\TagsBundle\Entity;

use DigitalAscetic\TagsBundle\Model\ITag;
use DigitalAscetic\TagsBundle\Model\ITaggable;
use Doctrine\ORM\Mapping as ORM;

abstract class AbstractTaggable implements ITaggable
{
    /**
     * @var string|null
     * @ORM\Column(name="tags", type="text", nullable=true)
     */
    protected $tags;

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