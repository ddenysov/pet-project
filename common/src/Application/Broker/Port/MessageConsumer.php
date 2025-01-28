<?php

namespace Common\Application\Broker\Port;

interface MessageConsumer
{
    /**
     * @param MessageChannel $channel
     * @return void
     */
    public function consume(MessageChannel $channel): void;
}