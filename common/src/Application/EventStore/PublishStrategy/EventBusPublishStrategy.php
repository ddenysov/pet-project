<?php

namespace Common\Application\EventStore\PublishStrategy;

use Common\Application\Bus\Port\EventBus;
use Common\Application\EventStore\PublishStrategy\Port\PublishStrategy;
use Common\Domain\Event\Port\Event;

class EventBusPublishStrategy implements PublishStrategy
{
    /**
     * @param EventBus $eventBus
     */
    public function __construct(private readonly EventBus $eventBus)
    {
    }

    /**
     * @param Event $event
     * @return void
     */
    public function handle(Event $event): void
    {
        $this->eventBus->dispatch($event);
    }
}