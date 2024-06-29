<?php

namespace User\Infrastructure\Persistence\Memory;

use User\Application\Outbox\OutboxStatus;
use User\Domain\Model\Event\DomainEvent;
use User\Infrastructure\Persistence\Memory\Data\OutboxDataset;

class OutboxRepository implements \User\Application\Outbox\OutboxRepository
{
    public function save(DomainEvent $event): void
    {
        OutboxDataset::$data[] = [
            'name'    => $event->getName(),
            'payload' => $event->toArray(),
            'status'  => OutboxStatus::STARTED,
        ];
    }
}