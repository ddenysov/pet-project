<?php

namespace Common\Infrastructure\Bus\Event;

use Common\Application\Bus\Port\EventBus as EventBusPort;
use Common\Domain\Event\Port\Event;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class EventBus implements EventBusPort
{
    /**
     * @param MessageBusInterface $bus
     */
    public function __construct(private MessageBusInterface $bus)
    {
    }

    /**
     * @param Event $event
     * @return void
     * @throws ExceptionInterface
     * @TODO Add exception handling
     */
    public function execute(Event $event): void
    {
        $this->bus->dispatch($event);
    }
}