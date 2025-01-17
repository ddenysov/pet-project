<?php

namespace Common\Application\Broker\Port;

interface MessageConsumer
{
    /**
     * @return void
     */
    public function consume(): void;
}