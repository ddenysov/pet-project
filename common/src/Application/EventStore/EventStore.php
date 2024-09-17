<?php

namespace Common\Application\EventStore;

use Common\Application\Outbox\Port\Outbox;
use Common\Domain\Event\Event;
use Psr\Log\LoggerInterface;

abstract class EventStore implements Port\EventStore
{
    public function __construct(
        private Outbox $outbox,
        private EventRouter $eventRouter,
        private LoggerInterface $logger,
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
    }

    /**
     * @param Event $event
     * @return mixed
     */
    abstract protected function save(Event $event);
}