<?php
declare(strict_types=1);

namespace Zinc\Core\Event\Repository;

use Zinc\Core\DataStore\DataStore;
use Zinc\Core\Domain\Event\EventStream;
use Zinc\Core\Domain\Root\Aggregate;
use Zinc\Core\Domain\Value\Uuid;
use Zinc\Core\Event\EventStore;
use Zinc\Core\Event\Exception\ConcurrencyException;

class EventStoreRepository
{
    public function __construct(private EventStore $store)
    {
    }

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

    public function find(Uuid $id)
    {

    }

    /**
     * @return DataStore
     */
    public function getDataStore(): DataStore
    {
        return $this->store->getDataStore();
    }
}