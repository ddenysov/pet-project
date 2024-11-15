<?php

namespace Common\Application\Handlers\Query\Result;

class PaginatedCollectionResult
{
    /**
     * @param array $collection
     * @param int $total
     */
    public function __construct(private array $collection, private int $total)
    {

    }

    public function getCollection(): array
    {
        return $this->collection;
    }

    public function getTotal(): int
    {
        return $this->total;
    }
}