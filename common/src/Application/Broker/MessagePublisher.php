<?php

namespace Common\Application\Broker;

use Common\Application\Broker\Port\MessageRepository;
use Common\Application\Broker\Port\Message;

class MessagePublisher implements Port\MessagePublisher
{

    public function __construct(private MessageRepository $repository)
    {
    }

    #[Override] public function publish(Message $message): void
    {
        $this->repository->save($message);
    }
}