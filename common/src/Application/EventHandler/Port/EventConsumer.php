<?php

namespace Common\Application\EventPublisher\Port;

use Common\Application\EventPublisher\Event;

interface EventConsumer
{
    /**
     * @param string $group
     * @param string $topic
     * @return void
     */
    public function consume(string $group, string $topic): void;
}