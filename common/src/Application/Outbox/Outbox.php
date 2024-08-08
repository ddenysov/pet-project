<?php

namespace Common\Application\Outbox;

use Common\Application\EventPublisher\Event as PublishableEvent;
use Common\Application\EventPublisher\Port\EventPublisher;
use Common\Application\Outbox\Port\OutboxRepository;
use Common\Domain\Event\Port\Event;
use Common\Domain\ValueObject\Uuid;
use Psr\Log\LoggerInterface;

class Outbox implements Port\Outbox
{
    public function __construct(
        private readonly OutboxRepository $outboxRepository,
        private readonly EventPublisher $eventPublisher,
        private LoggerInterface $logger
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
           $this->logger->info('Publishing event', [
               'id' => $message['id'],
           ]);
           $this->eventPublisher->publish(new PublishableEvent(
               eventId: Uuid::fromString($message['id']),
               aggregateId: Uuid::fromString($message['aggregate_id']),
               eventName: $message['name'],
               payload: json_decode($message['payload'], true),
           ), function (PublishableEvent $event) {
               $this->outboxRepository->complete($event->getEventId());
               $this->logger->info('Event published', [
                   'id' => $event->getEventId()->toString(),
               ]);
           }, function (PublishableEvent $event) {
               $this->outboxRepository->fail($event->getEventId());
               $this->logger->error('Event publish failed', [
                   'id' => $event->getEventId()->toString(),
               ]);
           });
       }
    }
}