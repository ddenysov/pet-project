<?php

namespace Common\Application\EventHandler;

use Psr\Log\LoggerInterface;

abstract class EventPublisher implements Port\EventPublisher
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    /**
     * @param Event $event
     * @param callable $success
     * @param callable $fail
     * @return void
     */
    final public function publish(Event $event, callable $success, callable $fail): void
    {
        try {
            $this->dispatch($event);
            $success($event);
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());
            $fail($exception);
        }
    }

    /**
     * @param Event $event
     * @return void
     */
    abstract protected function dispatch(Event $event): void;
}