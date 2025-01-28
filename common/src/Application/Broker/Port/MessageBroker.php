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
     * @param MessageChannel $channel
     * @return Message
     */
    public function consume(MessageChannel $channel): Message;
}