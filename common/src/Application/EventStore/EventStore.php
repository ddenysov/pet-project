<?php

namespace Common\Application\EventStore;

use Common\Application\Outbox\Port\Outbox;
use Common\Domain\Event\Event;

abstract class EventStore implements Port\EventStore
{
    public function __construct(private Outbox $outbox)
    {

    }

    /**
     * @param Event $event
     * @return Port\EventStore
     */
    final public function append(Event $event): Port\EventStore
    {
        $this->beforeAppend($event);
        $this->save($event);
        $this->afterAppend($event);

        return $this;
    }



    /**
     * @param Event $event
     * @return void
     */
    protected function beforeAppend(Event $event)
    {
        // do nothing
    }

    /**
     * @param Event $event
     * @return void
     */
    protected function afterAppend(Event $event)
    {
        $this->outbox->save($event);
    }

    /**
     * @param Event $event
     * @return mixed
     */
    abstract protected function save(Event $event);
}