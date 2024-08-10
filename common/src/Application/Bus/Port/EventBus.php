<?php

namespace Common\Application\Bus\Port;

use Common\Domain\Event\Port\Event;

interface EventBus
{
    /**
     * @param Event $event
     * @return void
     */
    public function dispatch(Event $event): void;
}