<?php

namespace Common\Application\EventPublisher\Port;

use Common\Application\EventPublisher\Event;

interface EventPublisher
{
    /**
     * @param Event $event
     * @param callable $success
     * @param callable $fail
     * @return void
     */
    public function publish(Event $event, callable $success, callable $fail): void;
}