<?php

namespace Common\Application\Broker\Port;

interface MessageBroker
{
    /**
     * @param Message $message
     * @return void
     */
    public function publish(Message $message): void;

    /**
     * @return Message
     */
    public function consume(): Message;
}