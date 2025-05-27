<?php

declare(strict_types=1);

namespace Zinc\Core\Command\Bridge\Symfony;

use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Zinc\Core\Command\CommandBusInterface;
use Zinc\Core\Command\CommandInterface;

/**
 * CommandBus adapter backed by Symfony Messenger.
 */
final readonly class MessengerCommandBus implements CommandBusInterface
{
    public function __construct(
        private MessageBusInterface $bus,
    ) {}

    /**
     * @throws ExceptionInterface
     */
    public function dispatch(CommandInterface $command): void
    {
        $this->bus->dispatch($command);
    }
}
