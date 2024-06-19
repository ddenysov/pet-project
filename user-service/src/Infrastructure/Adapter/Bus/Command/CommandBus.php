<?php

namespace User\Infrastructure\Adapter\Bus\Command;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use User\Application\Dto\Dto;
use User\Application\Handlers\Command\Command;
use User\Application\Handlers\Query\Query;

class CommandBus implements \User\Application\Ports\Output\Bus\CommandBus
{
    /**
     * @param MessageBusInterface $bus
     */
    public function __construct(private MessageBusInterface $bus)
    {
    }

    /**
     * @param Command $command
     * @return void
     * @throws ExceptionInterface
     * @TODO Add exception handling
     */
    public function execute(Command $command): void
    {
        $this->bus->dispatch($command);
    }
}