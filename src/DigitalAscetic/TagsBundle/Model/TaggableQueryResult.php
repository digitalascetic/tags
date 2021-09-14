<?php

namespace DigitalAscetic\TagsBundle\Model;

class TaggableQueryResult
{
    /** @var int */
    private $objectId;

    /** @var string */
    private $objectClass;

    /**
     * @param int $objectId
     * @param string $objectClass
     */
    public function __construct(int $objectId, string $objectClass)
    {
        $this->objectId = $objectId;
        $this->objectClass = $objectClass;
    }

    /**
     * @return int
     */
    public function getObjectId(): int
    {
        return $this->objectId;
    }

    /**
     * @return string
     */
    public function getObjectClass(): string
    {
        return $this->objectClass;
    }
}