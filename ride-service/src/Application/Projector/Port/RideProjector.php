<?php

namespace Ride\Application\Projector\Port;

use Ride\Domain\Event\HealthCheckOk;
use Ride\Domain\Event\RideEvent;

interface RideProjector
{
    /**
     * @param RideEvent $event
     * @return void
     */
    public function apply(RideEvent $event): void;
}