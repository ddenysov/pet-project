<?php

namespace Ride\Domain\Repository\Port;

use Common\Domain\ValueObject\Uuid;
use Ride\Domain\Entity\Healthcheck;
use Ride\Domain\Entity\Ride;
use Ride\Domain\ValueObject\RideId;

interface RideRepository
{
    /**
     * @param RideId $id
     * @return Ride
     */
    public function find(RideId $id): Ride;

    /**
     * @param Ride $entity
     * @return void
     */
    public function save(Ride $entity): void;
}