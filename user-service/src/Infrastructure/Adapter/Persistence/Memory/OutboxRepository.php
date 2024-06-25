<?php

namespace User\Infrastructure\Adapter\Persistence\Memory;

use User\Application\Outbox\OutboxStatus;
use User\Domain\Model\Event\DomainEvent;
use User\Infrastructure\Adapter\Persistence\Memory\Data\OutboxDataset;

class OutboxRepository implements \User\Application\Repository\OutboxRepository
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