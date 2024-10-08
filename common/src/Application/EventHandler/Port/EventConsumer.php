<?php

namespace Common\Application\EventHandler\Port;

interface EventConsumer
{
    /**
     * @param string $group
     * @return void
     */
    public function consume(string $group, string $topic): void;

    /**
     * @param array $map
     * @return void
     */
    public function configureChannelMap(array $map): void;
}