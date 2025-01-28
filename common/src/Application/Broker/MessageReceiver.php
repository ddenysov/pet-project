<?php

namespace Common\Application\Broker;

use Common\Application\Broker\Port\InboxMessageRepository;
use Common\Application\Broker\Port\MessageBroker;
use Common\Application\Broker\Port\MessageChannel;

class MessageReceiver implements \Common\Application\Broker\Port\MessageConsumer
{
    /**
     * @param MessageBroker $broker
     * @param InboxMessageStorage $storage
     */
    public function __construct(
        private MessageBroker $broker,
        private InboxMessageRepository $repository,
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
            if (!$this->repository->find($message->getId())) {
                $this->repository->save($message);
            }
            // deserialize
            // publish
        }
    }
}