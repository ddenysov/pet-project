<?php

namespace Common\Domain\Repository\Criteria;

class QueryCollection
{
    protected array $collection;

    public function add(Query $query): void
    {
        $this->collection[] = $query;
    }
}