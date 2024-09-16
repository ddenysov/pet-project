<?php

namespace Common\Application\EventStore\PublishStrategy\Port;

use Common\Domain\Event\Port\Event;

interface PublishStrategy
{
    public function handle(Event $event): void;
}