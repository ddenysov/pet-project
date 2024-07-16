<?php

namespace Common\Domain\Repository\Port;

interface Repository
{
    /**
     * @param Criteria $criteria
     * @return $this
     */
    public function addCriteria(Criteria $criteria): static;
}