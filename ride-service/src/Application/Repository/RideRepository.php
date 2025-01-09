<?php

namespace Ride\Application\Repository;

use Common\Application\Repository\PersistenceRepository;
use Common\Domain\ValueObject\Uuid;
use Ride\Domain\Entity\Healthcheck;
use Ride\Domain\Entity\Ride;
use Ride\Infrastructure\Persistence\Doctrine\Entity\EventStore;

class RideRepository extends PersistenceRepository implements \Ride\Domain\Repository\Port\RideRepository
{
    public function find(Uuid $id): Ride
    {
        $events = $this->eventStore->getEventStream($id, EventStore::class);

        return Ride::restore($events);
    }

    public function save(Ride $entity): void
    {
        $events = $entity->releaseEvents();

        foreach ($events as $event) {
            $this->eventStore->append($event);
        }
    }
}