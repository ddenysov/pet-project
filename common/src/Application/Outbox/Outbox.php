<?php

namespace Common\Application\Outbox;

use Common\Application\EventPublisher\Event as PublishableEvent;
use Common\Application\EventPublisher\Port\EventPublisher;
use Common\Application\Outbox\Port\OutboxRepository;
use Common\Domain\Event\Port\Event;
use Common\Domain\ValueObject\Uuid;

class Outbox implements Port\Outbox
{
    public function __construct(
        private readonly OutboxRepository $outboxRepository,
        private readonly EventPublisher $eventPublisher
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

    public function publish(int|null $limit = null): void
    {
       $messages = $this->outboxRepository->getUnpublishedMessages($limit);

       foreach ($messages as $message) {
           $this->eventPublisher->publish(new PublishableEvent(
               eventId: Uuid::fromString($message['id']),
               aggregateId: Uuid::fromString($message['aggregate_id']),
               eventName: $message['name'],
               payload: json_decode($message['payload'], true),
           ), function (PublishableEvent $event) {
               $this->outboxRepository->complete($event->getEventId());
               dump('ok');
           }, function (PublishableEvent $event) {
               dump('fail');
           });
           dump($message);
       }
    }
}