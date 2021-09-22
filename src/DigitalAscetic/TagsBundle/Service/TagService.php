<?php

namespace DigitalAscetic\TagsBundle\Service;

class TagService
{
    const SERVICE_NAME = "ascetic.tags.service";

    /** @var array */
    private $tagRelationshipsClasses;

    public function __construct()
    {
        $this->tagRelationshipsClasses = array();
    }

    public function addTagRelationshipClassName(string $tagRelationshipClassName)
    {
        if (!in_array($tagRelationshipClassName, $this->tagRelationshipsClasses)) {
            $this->tagRelationshipsClasses[] = $tagRelationshipClassName;
        }
    }

    /**
     * @return array
     */
    public function getTagRelationshipClassNames(): array
    {
        return $this->tagRelationshipsClasses;
    }
}