<?php

namespace Common\Application\EventHandler;

use Common\Application\EventStore\EventRouter;
use Exception;
use Psr\Log\LoggerInterface;
use Throwable;

abstract class EventPublisher implements Port\EventPublisher
{
    /**
     * @var array
     */
    protected array $channelMap = [];

    public function __construct(private readonly LoggerInterface $logger, private EventRouter $eventRouter)
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
            $eventName = $event->getEventName();
            $this->logger->info('Publishing event', [
                'event'   => $eventName,
                'channel' => $this->eventRouter->getChannel($event->getEventClass()),
            ]);
            $this->dispatch($event, $this->eventRouter->getChannel($event->getEventClass()));
            $this->logger->info('Event published', [
                'event'   => $eventName,
            ]);
            $success($event);
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage());
            $fail($exception);
        }
    }

    /**
     * @param Event $event
     * @param string $channel
     * @return void
     */
    abstract protected function dispatch(Event $event, string $channel): void;
}