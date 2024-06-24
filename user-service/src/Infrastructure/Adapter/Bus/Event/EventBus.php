<?php

namespace User\Infrastructure\Adapter\Bus\Event;

use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use User\Domain\Model\Event\DomainEvent;

class EventBus implements \User\Application\Ports\Output\Bus\EventBus
{
    /**
     * @param MessageBusInterface $bus
     */
    public function __construct(private MessageBusInterface $bus)
    {
    }

    /**
     * @param DomainEvent $event
     * @return void
     * @throws ExceptionInterface
     * @TODO Add exception handling
     */
    public function execute(DomainEvent $event): void
    {
        $this->bus->dispatch($event);
    }
}