<?php

namespace Common\Application\Outbox;

use Common\Application\Bus\Port\EventBus;
use Common\Application\Outbox\Port\OutboxRepository;
use Common\Domain\Event\Port\Event;

class Outbox implements Port\Outbox
{
    public function __construct(
        private readonly OutboxRepository $outboxRepository
    )
    {
    }

    public function save(Event $event): void
    {
        $this->outboxRepository->save(
            name: $event->getName(),
            eventId: $event->getId(),
            aggregateId: $event->getAggregateId(),
            payload: $event->toArray(),
        );
    }

    public function publish(int $limit = null): void
    {
       $messages = $this->outboxRepository->getUnpublishedMessages($limit);

       foreach ($messages as $message) {
           $this->eventBus->execute();
       }
    }

}