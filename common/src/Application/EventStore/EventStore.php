<?php

namespace Common\Application\EventStore;

use Common\Application\EventStore\Port\SsePublisher;
use Common\Application\Outbox\Port\Outbox;
use Common\Domain\Event\Event;
use Psr\Log\LoggerInterface;

abstract class EventStore implements Port\EventStore
{
    public function __construct(
        private Outbox $outbox,
        private EventRouter $eventRouter,
        private LoggerInterface $logger,
        private SsePublisher $ssePublisher,
    )
    {

    }

    /**
     * @param Event $event
     * @return Port\EventStore
     */
    final public function append(Event $event): Port\EventStore
    {
        $this->save($event);
        $this->publish($event);

        return $this;
    }

    protected function publish(Event $event): void
    {
        $strategy = $this->eventRouter->getTransportStrategy($event);
        $strategy->handle($event);

        if ($this->eventRouter->hasSse($event)) {
            $this->ssePublisher->publish($event);
        }
    }

    /**
     * @param Event $event
     * @return mixed
     */
    abstract protected function save(Event $event);
}