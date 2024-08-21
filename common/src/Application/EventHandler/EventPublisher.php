<?php

namespace Common\Application\EventHandler;

use Exception;
use Psr\Log\LoggerInterface;
use Throwable;

abstract class EventPublisher implements Port\EventPublisher
{
    /**
     * @var array
     */
    protected array $channelMap = [];

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
            $eventName = $event->getEventName();
            if (!$this->channelMap[$eventName]) {
                throw new Exception('There are no channel configured for this event');
            }
            $this->logger->info('Publishing event', [
                'event'   => $eventName,
                'channel' => $this->channelMap[$eventName],
            ]);
            $this->dispatch($event, $this->channelMap[$eventName]);
            $success($event);
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage());
            $fail($exception);
        }
    }

    /**
     * @param array $map
     * @return void
     */
    public function configureChannelMap(array $map): void
    {
        foreach ($map as $channel => $events) {
            foreach ($events as $event) {
                $this->channelMap[$event] = $channel;
            }
        }
    }

    /**
     * @param Event $event
     * @param string $channel
     * @return void
     */
    abstract protected function dispatch(Event $event, string $channel): void;
}