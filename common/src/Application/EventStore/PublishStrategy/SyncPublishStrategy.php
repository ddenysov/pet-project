<?php

namespace Common\Application\EventStore\PublishStrategy;

use Common\Application\Bus\Port\EventBus;
use Common\Application\EventStore\PublishStrategy\Port\PublishStrategy;
use Common\Application\Outbox\Port\Outbox;
use Common\Domain\Event\Port\Event;

final readonly class SyncPublishStrategy implements PublishStrategy
{
    /**
     * @param EventBus $eventBus
     * @param Outbox $outbox
     */
    public function __construct(
        private readonly EventBus $eventBus,
        private readonly Outbox $outbox,
    ) {
    }

    /**
     * @param Event $event
     * @return void
     */
    public function handle(Event $event): void
    {
        $this->eventBus->dispatch($event);
        $this->outbox->save($event);
    }
}