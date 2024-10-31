<?php

namespace Common\Application\Repository\Criteria;

class Criteria
{
    /**
     * @var array
     */
    protected array $criteria = [];

    /**
     * @param Criteria $criteria
     * @return $this
     */
    public function addCriteria(self $criteria): static
    {
        $this->criteria[$criteria::class] = $criteria;

        return $this;
    }
}