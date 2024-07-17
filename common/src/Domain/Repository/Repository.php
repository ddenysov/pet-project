<?php

namespace Common\Domain\Repository;

use Common\Domain\Repository\Port\Criteria;

abstract class Repository
{
    protected array $criteria = [];

    public function addCriteria(Criteria $criteria): static
    {
        $this->criteria[$criteria::class] = $criteria;
    }

    /**
     * @return $this
     */
    public function applyCriteria(): static
    {
        foreach ($this->criteria as $criteria) {
            $criteria->apply($this);
        }
    }
}