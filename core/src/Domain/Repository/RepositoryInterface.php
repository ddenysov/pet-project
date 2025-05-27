<?php

declare(strict_types=1);

namespace Zinc\Core\Domain\Repository;

use Zinc\Core\Domain\Aggregate\AggregateRootInterface;
use Zinc\Core\Domain\Event\EventStreamInterface;
use Zinc\Core\Domain\Value\Uuid;

interface RepositoryInterface
{
    public function save(AggregateRootInterface $aggregate): EventStreamInterface;

    public function find(Uuid $uuid);
}
