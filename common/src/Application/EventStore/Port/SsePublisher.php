<?php

namespace Common\Application\EventStore\Port;

use Common\Domain\Event\Port\Event;

interface SsePublisher
{
    public function publish(Event $event): void;
}