<?php

namespace Common\Application\EventStore;

use Common\Application\Outbox\Port\Outbox;
use Common\Domain\Event\Event;
use Common\Domain\Event\EventStream;
use Common\Domain\ValueObject\Uuid;
use Psr\Log\LoggerInterface;

abstract class EventStore implements Port\EventStore
{
    public function __construct(
        private Outbox $outbox,
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
        $this->logger->info('Event saved to event store: ' . $event::getEventName(), $event->payload());
        $this->outbox->save($event);
    }

    /**
     * @param Event $event
     * @return mixed
     */
    abstract protected function save(Event $event);
}