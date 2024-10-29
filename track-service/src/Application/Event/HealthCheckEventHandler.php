<?php

namespace Track\Application\Event;

use Iam\Application\Projector\Port\UserProjector;
use Track\Application\Projector\Port\HealthCheckProjector;
use Track\Domain\Event\HealthCheckOk;

class HealthCheckEventHandler
{
    public function __construct(private HealthCheckProjector $projector)
    {
    }

    public function __invoke(HealthCheckOk $event)
    {
        dump('HANDLED');
        $this->projector->apply($event);
    }

}