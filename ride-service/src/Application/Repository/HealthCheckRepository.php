<?php

namespace Ride\Application\Repository;

use Common\Application\Repository\PersistenceRepository;
use Common\Domain\ValueObject\Uuid;
use Ride\Domain\Entity\Healthcheck;

class HealthCheckRepository extends PersistenceRepository implements \Ride\Domain\Repository\Port\HealthCheckRepository
{
    public function find(Uuid $id): Healthcheck
    {
        $events = $this->eventStore->getEventStream($id);

        return Healthcheck::restore($events);
    }

    public function save(Healthcheck $entity): void
    {
        $events = $entity->releaseEvents();

        foreach ($events as $event) {
            $this->eventStore->append($event);
        }
    }
}