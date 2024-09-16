<?php

namespace Common\Application\EventStore\PublishStrategy;

use Common\Application\Bus\Port\EventBus;
use Common\Application\EventStore\PublishStrategy\Port\PublishStrategy;
use Common\Application\Outbox\Port\Outbox;
use Common\Domain\Event\Port\Event;

class AllPublishStrategy implements PublishStrategy
{
    /**
     * @param Outbox $outbox
     * @param EventBus $eventBus
     */
    public function __construct(
        private readonly Outbox $outbox,
        private readonly EventBus $eventBus,
    ) {
    }

    /**
     * @param Event $event
     * @return void
     */
    public function handle(Event $event): void
    {
        $this->outbox->save($event);
        $this->eventBus->dispatch($event);
    }
}