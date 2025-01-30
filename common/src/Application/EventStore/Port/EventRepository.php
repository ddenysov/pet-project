<?php

namespace Common\Application\EventStore\Port;

use Common\Application\Repository\HasOffsets;
use Common\Application\Repository\HasTransactions;
use Common\Domain\Event\Event;
use Common\Domain\Event\Port\EventStream;
use Common\Domain\ValueObject\Uuid;

interface EventRepository extends HasTransactions, HasOffsets
{
    /**
     * @param Event $event
     * @return void
     */
    public function append(Event $event): void;

    /**
     * @param Uuid $aggregateId
     * @return EventStream
     */
    public function stream(Uuid $aggregateId): EventStream;
}