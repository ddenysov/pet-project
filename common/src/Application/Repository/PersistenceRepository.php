<?php

namespace Common\Application\Repository;

use Common\Application\Bus\Port\EventBus;
use Common\Application\EventStore\Port\EventStore;
use Common\Domain\Entity\Aggregate;
use Common\Domain\ValueObject\Uuid;
use Track\Domain\Entity\Track;

class PersistenceRepository
{
    public function __construct(
        protected EventStore $eventStore,
        protected EventBus $eventBus,
    ) {
    }

    /**
     * @param Aggregate $aggregate
     * @return void
     */
    protected function saveToEventStore(Aggregate $aggregate): void
    {
        $events = $aggregate->releaseEvents();

        foreach ($events as $event) {
            $this->eventStore->append($event);
        }
    }

    /**
     * @param Uuid $id
     * @return \Common\Domain\Entity\Port\Aggregate
     */
    public function restoreAggregate(Uuid $id): \Common\Domain\Entity\Port\Aggregate
    {
        $events = $this->eventStore->getEventStream($id, \Ride\Infrastructure\Persistence\Doctrine\Entity\EventStore::class);

        return Track::restore($events);
    }

    protected function getAggregateClass(): string
    {
        return '';
    }
}