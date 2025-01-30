<?php

namespace Common\Application\EventStore;

use Common\Application\Broker\Message;
use Common\Application\Broker\Port\MessageOutboxRepository;
use Common\Application\EventStore\Port\EventRepository;
use Common\Domain\Event\Port\Event;
use Common\Domain\Event\Port\EventStream;
use Common\Domain\ValueObject\Uuid;

class EventStore implements Port\EventStore
{
    public function __construct(
        private MessageOutboxRepository $outboxRepository,
        private EventRepository $eventRepository,
    )
    {

    }

    /**
     * @param EventStream|Event $events
     * @return Port\EventStore
     * @throws \Throwable
     */
    final public function append(EventStream|Event $events): Port\EventStore
    {
        if ($events instanceof Event) {
            $events = new \Common\Domain\Event\EventStream([$events]);
        }
        $this->outboxRepository->startTransaction();
        $this->eventRepository->startTransaction();
        try {
            foreach ($events as $event) {
                $this->eventRepository->append($event);
                $this->outboxRepository->save(new Message($event->getId()->toString(), $event->toArray()));
            }

        } catch (\Throwable $exception) {
            $this->eventRepository->rollback();
            $this->outboxRepository->rollback();
            throw $exception;
        }
        $this->eventRepository->commit();
        $this->outboxRepository->commit();

        return $this;
    }

    /**
     * @param Uuid $id
     * @return EventStream
     */
    #[\Override] public function load(Uuid $id): EventStream
    {
        return $this->eventRepository->stream($id);
    }
}