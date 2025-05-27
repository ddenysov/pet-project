<?php
declare(strict_types=1);

namespace Denysov\Demo\Domain\Model\Ping;

use Denysov\Demo\Domain\Model\Ping\Event\PingCreated;
use Tests\Stub\StubDomainEvent;
use Zinc\Core\Domain\Aggregate\AbstractAggregateRoot;
use Zinc\Core\Domain\Aggregate\AggregateRootInterface;
use Zinc\Core\Domain\Value\Uuid;

class Ping extends AbstractAggregateRoot implements AggregateRootInterface
{
    public function getId(): PingId
    {
        return $this->id;
    }

    public static function create(PingId $id): self
    {
        $instance = new self();
        $instance->recordThat(new PingCreated(aggregateId: $id));

        return $instance;
    }

    public function onPingCreated(PingCreated $event)
    {
        $this->id = $event->getAggregateId();
    }
}