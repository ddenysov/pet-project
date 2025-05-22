<?php

declare(strict_types=1);

namespace Zinc\Core\Event\Proxy;

use Zinc\Core\Domain\Event\Event;
use Zinc\Core\Domain\Event\EventStream;
use Zinc\Core\Event\EventBus;
use Zinc\Core\Logging\LogManager;

class LoggingEventBusProxy implements EventBus
{
    public function __construct(
        private readonly EventBus $inner,
        private readonly LogManager $logger,
    ) {}

    /**
     * @throws \Throwable
     */
    public function append(EventStream $stream)
    {
        return $this->logger->log(
            fn() => $this->inner->append($stream),
            'Saving stream to Event Store',
        );
    }

    public function dispatch(Event $event): void
    {
        $this->logger->log(
            fn() => $this->inner->dispatch($event),
            'Dispatching event tp event bus',
            [
                'payload' => $event->toArray(),
            ],
        );
    }

    #[\Override]
    public function dispatchMany(EventStream $stream): void
    {
        foreach ($stream as $event) {
            $this->dispatch($event);
        }
    }
}
