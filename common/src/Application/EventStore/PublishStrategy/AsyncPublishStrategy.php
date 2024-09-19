<?php

namespace Common\Application\EventStore\PublishStrategy;

use Common\Application\EventStore\PublishStrategy\Port\PublishStrategy;
use Common\Application\Outbox\Port\Outbox;
use Common\Domain\Event\Port\Event;

class AsyncPublishStrategy implements PublishStrategy
{
    /**
     * @param Outbox $outbox
     */
    public function __construct(private readonly Outbox $outbox)
    {
    }

    /**
     * @param Event $event
     * @return void
     */
    public function handle(Event $event): void
    {
        $this->outbox->save($event);
    }
}