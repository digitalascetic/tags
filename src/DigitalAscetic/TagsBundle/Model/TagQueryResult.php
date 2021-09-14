<?php

namespace DigitalAscetic\TagsBundle\Model;

class TagQueryResult
{
    /** @var int */
    private $total;

    /** @var TaggableQueryResult[] */
    private $results;

    /**
     * @param int $total
     * @param array $results
     */
    public function __construct(int $total, array $results = array())
    {
        $this->total = $total;
        $this->results = $results;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return TaggableQueryResult[]
     */
    public function getResults(): array
    {
        return $this->results;
    }

    public function addResult(TaggableQueryResult $taggableQueryResult)
    {
        $this->results[] = $taggableQueryResult;
    }
}