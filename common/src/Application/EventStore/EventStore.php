<?php

namespace Common\Application\EventStore;

use Common\Application\Bus\Port\EventBus;
use Common\Domain\Event\Event;

abstract class EventStore implements Port\EventStore
{
    public function __construct(
        private EventBus $eventBus,
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
        $this->eventBus->dispatch($event);

        return $this;
    }

    /**
     * @param Event $event
     * @return void
     */
    abstract protected function save(Event $event): void;
}