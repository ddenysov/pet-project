<?php

namespace Common\Application\Broadcaster\Port;

use Common\Domain\Event\Event;
use Common\Domain\ValueObject\Uuid;

interface Broadcaster
{
    /**
     * @param Uuid $identity
     * @param Event $event
     * @return void
     */
    public function broadcastMessageTo(
        Uuid $identity,
        Event $event,
    ): void;

    /**
     * @param Event $event
     * @return void
     */
    public function broadcastMessage(
        Event $event,
    ): void;
}