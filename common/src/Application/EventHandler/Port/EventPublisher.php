<?php

namespace Common\Application\EventHandler\Port;

use Common\Application\EventHandler\Event;

interface EventPublisher
{
    /**
     * @param Event $event
     * @param callable $success
     * @param callable $fail
     * @return void
     */
    public function publish(Event $event, callable $success, callable $fail): void;

    /**
     * @param array $map
     * @return mixed
     */
    public function configureChannelMap(array $map): void;
}