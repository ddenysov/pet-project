<?php

declare(strict_types=1);

namespace Zinc\Core\Domain\Repository;

use Zinc\Core\Domain\Event\EventStream;
use Zinc\Core\Domain\Aggregate\Aggregate;

interface Repository
{
    public function save(Aggregate $aggregate): EventStream;
}
