<?php

namespace Common\Infrastructure\Bus\Command;

use Common\Application\Bus\Port\CommandBus as CommandBusPort;
use Common\Application\Handlers\Command\Port\Command;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CommandBus implements CommandBusPort
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