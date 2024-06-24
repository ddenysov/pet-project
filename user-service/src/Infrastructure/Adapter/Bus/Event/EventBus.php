<?php

namespace User\Infrastructure\Adapter\Bus\Command;

use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use User\Application\Handlers\Command\Command;
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