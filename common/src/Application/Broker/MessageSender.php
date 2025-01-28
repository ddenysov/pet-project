<?php

namespace Common\Application\Broker;

use Common\Application\Broker\Port\MessageBroker;
use Common\Application\Broker\Port\OutboxMessageRepository;

class MessageSender
{
    public function __construct(private OutboxMessageRepository $repository, private MessageBroker $broker)
    {
    }

    public function send(int $number = 10): void
    {
        while (true) {
            /**
             * @var Message[] $messages
             */
            $messages = $this->repository->pending()->limit($number)->get();
            foreach ($messages as $message) {
                $this->broker->publish($message);
                $message->complete();
                $this->repository->save($message);
            }
            sleep(1);
        }
    }
}