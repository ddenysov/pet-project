<?php

namespace Common\Domain\Repository;

use Common\Domain\Repository\Port\Collection;
use Common\Domain\Repository\Port\Criteria;

abstract class Repository implements Port\Repository
{
    public function match(Criteria $criteria): Collection
    {

    }
}