<?php

namespace DigitalAscetic\TagsBundle\Model;

class TagQueryResult
{
    /** @var int */
    private $id;

    /** @var string */
    private $objectClass;

    /**
     * @param int $id
     * @param string $objectClass
     */
    public function __construct(int $id, string $objectClass)
    {
        $this->id = $id;
        $this->objectClass = $objectClass;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getObjectClass(): string
    {
        return $this->objectClass;
    }
}