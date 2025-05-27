<?php
declare(strict_types=1);

namespace Tests\Stub;

use Zinc\Core\Domain\Aggregate\Aggregate;
use Zinc\Core\Domain\Value\Uuid;

class StubAggregate extends Aggregate
{
    public static function create(Uuid $id): self
    {
        $instance = new self();
        $instance->recordThat(new StubDomainEvent(
            Uuid::create(),
        ));

        return $instance;
    }

    public function onStubDomainEvent(StubDomainEvent $event)
    {
        $this->id = $event->getAggregateId();
    }
}