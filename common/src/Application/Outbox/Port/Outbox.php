<?php

namespace Common\Application\Outbox\Port;

use Common\Domain\Event\Port\Event;

interface Outbox
{
    public function save(Event $event): void;

    public function publish(int $limit = null): void;
}