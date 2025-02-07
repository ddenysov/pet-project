<?php

namespace Common\Application\Broker;

use Common\Application\Broker\Port\InboxMessageRepository;
use Common\Application\Broker\Port\MessageBroker;
use Common\Application\Broker\Port\MessageChannel;

class MessageConsumer implements \Common\Application\Broker\Port\MessageConsumer
{
    /**
     * @param MessageBroker $broker
     */
    public function __construct(
        private MessageBroker $broker,
    ) {
    }

    /**
     * @param MessageChannel $channel
     * @return void
     */
    #[\Override] public function consume(MessageChannel $channel): void
    {
        // consume WHAT ? Topic / partition
        while ($message = $this->broker->consume($channel)) {

        }
    }
}