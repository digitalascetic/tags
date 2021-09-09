<?php

namespace DigitalAscetic\BaseTagBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait TaggableTrait
{
    /**
     * @var string|null $notificationTopics
     *
     * @ORM\Column(name="tags", type="string", nullable=true)
     */
    private $tags;

    public function addTag(int $tag)
    {
        if ($this->hasTag($tag) === false) {
            $this->tags = $this->tags | $tag;
        }
    }

    public function hasTag(int $tag): bool
    {
        return (($this->tags & $tag) === $tag);
    }

    public function removeTag(int $tag)
    {
        if ($this->hasTag($tag)) {
            $this->tags &= ~$tag;
        }
    }
}