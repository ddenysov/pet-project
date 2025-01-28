<?php

namespace Common\Application\Broker\Port;

interface MessagePublisher
{
    /**
     * @param Message $message
     * @return void
     */
    public function publish(Message $message): void;
}