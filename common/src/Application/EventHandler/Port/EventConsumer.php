<?php

namespace Common\Application\EventHandler\Port;

interface EventConsumer
{
    /**
     * @param string $group
     * @param string $topic
     * @return void
     */
    public function consume(string $group, string $topic): void;
}