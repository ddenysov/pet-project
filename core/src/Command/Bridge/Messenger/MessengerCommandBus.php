<?php
declare(strict_types=1);

namespace Zinc\Core\Command\Bridge\Messenger;

use Zinc\Core\Command\AbstractCommandBus;
use Zinc\Core\Command\Command;
use Zinc\Core\Command\MiddlewareInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * CommandBus adapter backed by Symfony Messenger.
 */
final class MessengerCommandBus extends AbstractCommandBus
{
    public function __construct(
        private MessageBusInterface $messengerBus,
        MiddlewareInterface ...$middleware
    ) {
        parent::__construct(...$middleware);
    }

    protected function innerDispatch(Command $command): mixed
    {
        return $this->messengerBus->dispatch($command);
    }
}
