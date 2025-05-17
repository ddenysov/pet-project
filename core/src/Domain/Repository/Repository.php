<?php

namespace Zinc\Core\Domain\Repository;

use Zinc\Core\Domain\Event\EventStream;
use Zinc\Core\Domain\Root\Aggregate;

interface Repository
{
    public function save(Aggregate $aggregate): EventStream;
}