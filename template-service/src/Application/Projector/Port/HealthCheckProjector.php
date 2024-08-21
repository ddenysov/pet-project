<?php

namespace Template\Application\Projector\Port;

use Template\Domain\Event\HealthCheckOk;

interface HealthCheckProjector
{
    /**
     * @param HealthCheckOk $event
     * @return void
     */
    public function apply(HealthCheckOk $event): void;
}