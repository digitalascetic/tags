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
    #[ORM\Column(name: "tags", type: "text", nullable: true)]
    protected ?string $tags = null;

    public function getIdTags(): array
    {
        if (is_null($this->tags)) {
            return [];
        }

        return array_values(json_decode($this->tags, true));
    }

    public function addTag(ITag $tag): void
    {
        $tags = $this->getIdTags();

        if (!in_array($tag->getId(), $this->getIdTags())) {
            array_push($tags, $tag->getId());
        }

        $this->tags = json_encode($tags);
    }

    public function removeTag(ITag $tag): void
    {
        $tags = $this->getIdTags();

        if (in_array($tag->getId(), $this->getIdTags())) {
            $tagIndex = array_search($tag->getId(), $tags);
            unset($tags[$tagIndex]);
        }

        $this->tags = json_encode($tags);
    }
}
