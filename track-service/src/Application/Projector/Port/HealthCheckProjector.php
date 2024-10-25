<?php

namespace Track\Application\Projector\Port;

use Track\Domain\Event\HealthCheckOk;

interface HealthCheckProjector
{
    /**
     * @param HealthCheckOk $event
     * @return void
     */
    public function apply(HealthCheckOk $event): void;
}