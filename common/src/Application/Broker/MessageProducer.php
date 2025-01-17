<?php

namespace Common\Application\Broker;

use Common\Application\Broker\Port\Message;
use Common\Application\Broker\Port\MessageBroker;
use Common\Application\Broker\Port\MessagePublisher;
use Common\Application\Broker\Port\OutboxMessageStorage;

class MessageProducer implements MessagePublisher
{

    public function __construct(
        private OutboxMessageStorage $storage,
        private MessageBroker $broker
    ) {
    }

    #[\Override] public function publish(): void
    {
        /**
         * @var Message[] $messages
         */
        $messages = $this->storage->get();

        foreach ($messages as $message) {
            $this->broker->publish($message);
            $message->markDone();
            $this->storage->store($message);
        }
        // get from outbox
        // send
        // mark as sent
    }
}