<?php

namespace Ride\Application\Projector\Port;

use Ride\Domain\Event\HealthCheckOk;

interface HealthCheckProjector
{
    /**
     * @param HealthCheckOk $event
     * @return void
     */
    public function apply(HealthCheckOk $event): void;
}