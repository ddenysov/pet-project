<?php

namespace Template\Domain\Entity;

use Common\Domain\Entity\Aggregate;
use Common\Domain\ValueObject\Uuid;
use Template\Domain\Event\HealthCheckOk;

class Healthcheck extends Aggregate implements \Common\Domain\Entity\Port\Aggregate
{
    public static function execute(): Healthcheck {
        $instance = new static();
        $instance->setId(Uuid::create());
        $event = new HealthCheckOk();
        $event->setAggregateId($instance->getId());
        $instance->recordThat($event);

        return $instance;
    }

    public function onHealthCheckOk()
    {
        // do nothing
    }
}