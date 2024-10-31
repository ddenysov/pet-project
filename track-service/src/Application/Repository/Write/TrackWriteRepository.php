<?php

namespace Track\Application\Repository\Write;

use Common\Application\Repository\WriteRepository;
use Common\Domain\ValueObject\Uuid;
use Ride\Infrastructure\Persistence\Doctrine\Entity\EventStore;
use Track\Domain\Entity\Track;

class TrackWriteRepository extends WriteRepository implements \Track\Domain\Repository\Port\TrackRepository
{
    public function find(Uuid $id): Track
    {
        $events = $this->eventStore->getEventStream($id, EventStore::class);

        return Track::restore($events);
    }

    public function save(Track $entity): void
    {
        $this->saveToEventStore($entity);
    }

    #[\Override] protected function getAggregateClass(): string
    {
        return Track::class;
    }
}