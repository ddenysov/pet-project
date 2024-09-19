<?php

namespace Common\Application\EventStore;

use Common\Application\Container\Port\ServiceContainer;
use Common\Application\EventStore\PublishStrategy\AllPublishStrategy;
use Common\Application\EventStore\PublishStrategy\AsyncPublishStrategy;
use Common\Application\EventStore\PublishStrategy\EventBusPublishStrategy;
use Common\Application\EventStore\PublishStrategy\OutboxPublishStrategy;
use Common\Application\EventStore\PublishStrategy\Port\PublishStrategy;
use Common\Application\EventStore\PublishStrategy\SsePublishStrategy;
use Common\Application\EventStore\PublishStrategy\SyncPublishStrategy;
use Common\Domain\Event\Port\Event;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class EventRouter
{
    /**
     * @var array
     */
    private array $channels = [];

    /**
     * @var array
     */
    private array $transports = [];

    /**
     * @var array
     */
    private array $sse = [];

    /**
     * Type sync
     */
    private const TRANSPORT_TYPE_SYNC = 'sync';

    /**
     * Type async
     */
    private const TRANSPORT_TYPE_ASYNC = 'async';

    /**
     * @var array|string[]
     */
    private static array $STRATEGIES = [
        self::TRANSPORT_TYPE_ASYNC => AsyncPublishStrategy::class,
        self::TRANSPORT_TYPE_SYNC => SyncPublishStrategy::class,
    ];

    public function __construct(private ServiceContainer $container)
    {
    }


    /**
     * @param string $event
     * @param string $channel
     * @return void
     */
    public function registerChannel(string $event, string $channel): void
    {
        $this->channels[$event] = $channel;
    }

    /**
     * @param string $event
     * @param string $channel
     * @return void
     */
    public function registerTransport(string $event, string $channel): void
    {
        $this->transports[$event] = $channel;
    }

    /**
     * @param string $event
     * @return string
     */
    public function getTransport(string $event): string
    {
        return $this->transports[$event];
    }

    /**
     * @param string $event
     * @return string
     */
    public function getChannel(string $event): string
    {
        return $this->channels[$event];
    }

    /**
     * @param string $event
     * @param bool $isEnabled
     * @return void
     */
    public function registerSse(string $event, bool $isEnabled): void
    {
        $this->sse[$event] = $isEnabled;
    }

    /**
     * @param string $event
     * @return bool
     */
    public function hasSse(string|Event $event): bool
    {
        if ($event instanceof Event) {
            $event = get_class($event);
        }

        return $this->sse[$event] ?? false;
    }

    /**
     * @param string|Event $event
     * @return PublishStrategy
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getTransportStrategy(string|Event $event): PublishStrategy
    {
        if ($event instanceof Event) {
            $event = get_class($event);
        }

        return $this->container->get(self::$STRATEGIES[$this->getTransport($event)]);
    }
}