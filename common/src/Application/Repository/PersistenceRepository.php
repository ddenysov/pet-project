<?php

namespace Common\Application\Repository;

use Common\Application\EventStore\Port\EventStore;

class PersistenceRepository
{
    public function __construct(protected EventStore $eventStore)
    {
    }
}