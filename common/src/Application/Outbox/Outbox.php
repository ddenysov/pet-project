<?php

namespace Common\Application\Outbox;

use Common\Application\EventHandler\Event as PublishableEvent;
use Common\Application\EventHandler\Port\EventPublisher;
use Common\Application\Outbox\Port\OutboxRepository;
use Common\Domain\Event\Port\Event;
use Common\Domain\ValueObject\Uuid;
use Psr\Log\LoggerInterface;

class Outbox implements Port\Outbox
{
    public function __construct(
        private readonly OutboxRepository $outboxRepository,
        private readonly EventPublisher   $eventPublisher,
        private LoggerInterface           $logger
    )
    {
    }

    /**
     * @param Event $event
     * @return void
     */
    public function save(Event $event): void
    {
        $this->outboxRepository->save(
            eventId: $event->getId(),
            name: $event::getName(),
            payload: $event->toArray(),
        );
        $this->logger->info('Event saved to outbox: ' . $event::getName());
    }

    public function publish(int|null $limit = null): void
    {
        try {
            $messages = $this->outboxRepository->getUnpublishedMessages($limit);

            foreach ($messages as $message) {
                $this->logger->info('Outbox: Publishing event', [
                    'id' => $message['id'],
                ]);
                $this->eventPublisher->publish(new PublishableEvent(
                    eventId: Uuid::fromString($message['id']),
                    eventName: $message['name'],
                    payload: json_decode($message['payload'], true),
                ), function (PublishableEvent $event) {
                    $this->outboxRepository->complete($event->getEventId());
                    $this->logger->info('Event published', [
                        'id'   => $event->getEventId()->toString(),
                        'name' => $event->getEventName(),
                    ]);
                }, function (PublishableEvent $event) {
                    $this->outboxRepository->fail($event->getEventId());
                    $this->logger->error('Event publish failed', [
                        'id'   => $event->getEventId()->toString(),
                        'name' => $event->getEventName(),
                    ]);
                });
            }
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage(), [
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ]);
        }

    }
}