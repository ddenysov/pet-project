<?php

namespace Common\Application\Broker;

use Common\Application\Broker\Port\InboxMessageStorage;
use Common\Application\Broker\Port\MessageBroker;

class MessageConsumer implements \Common\Application\Broker\Port\MessageConsumer
{
    /**
     * @param MessageBroker $broker
     * @param InboxMessageStorage $storage
     */
    public function __construct(
        private MessageBroker $broker,
        private InboxMessageStorage $storage,
    ) {
    }

    /**
     * @return void
     */
    #[\Override] public function consume(): void
    {
        while ($message = $this->broker->consume()) {
            if (!$this->storage->find($message->getId())) {
                $this->storage->store($message);
            }
            // check if message already processed
            // save to repository
        }
    }
}