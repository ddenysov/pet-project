<?php

namespace Common\Application\Broker;

use Common\Application\Broker\Port\MessageBroker;
use Common\Application\Broker\Port\MessageOutboxRepository;

class MessagePublisher
{
    public function __construct(private MessageOutboxRepository $repository, private MessageBroker $broker)
    {
    }

    public function publish(int $number = 10): void
    {
        while (true) {
            /**
             * @var Message[] $messages
             */
            $messages = $this->repository->pending()->limit($number)->get();
            foreach ($messages as $message) {
                $this->repository->startTransaction();
                try {
                    $this->repository->complete($message);
                    $this->broker->publish($message);
                    $this->repository->commit();
                } catch (\Throwable $exception) {
                    $this->repository->rollback();
                }
            }
            sleep(1);
        }
    }
}