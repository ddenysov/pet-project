<?php

declare(strict_types=1);

namespace Zinc\Core\Repository;

use Zinc\Core\DataStore\DataStore;
use Zinc\Core\Domain\Event\EventStream;
use Zinc\Core\Domain\Repository\Repository;
use Zinc\Core\Domain\Aggregate\Aggregate;
use Zinc\Core\Domain\Value\Uuid;
use Zinc\Core\Event\EventStore;
use Zinc\Core\Event\Exception\ConcurrencyException;

class EventStoreRepository implements Repository
{
    public function __construct(private EventStore $store) {}

    /**
     * @throws ConcurrencyException
     */
    public function save(Aggregate $aggregate): EventStream
    {
        $expectedVersion = $aggregate->getPreviousVersion();
        $actualVersion   = $this->store->getStreamRevision($aggregate->getId());

        if ($expectedVersion !== $actualVersion) {
            throw new ConcurrencyException('Expected version: ' . $expectedVersion . ', but got: ' . $actualVersion);
        }

        $events = $aggregate->releaseEvents();
        $this->store->append($events);

        return $events;
    }

    public function find(Uuid $id): void {}

    public function getDataStore(): DataStore
    {
        return $this->store->getDataStore();
    }
}
