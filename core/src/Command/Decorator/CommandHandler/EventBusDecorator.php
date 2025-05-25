<?php

declare(strict_types=1);

namespace Zinc\Core\Command\Decorator\CommandHandler;

use Zinc\Core\Command\CommandHandlerInterface;
use Zinc\Core\Command\CommandInterface;

class EventBusDecorator implements CommandHandlerInterface
{
    public function __construct(private CommandHandlerInterface $inner)
    {
    }

    public function __invoke(CommandInterface $command)
    {
        $result = $this->inner->__invoke($command);

        return $result;
    }
}
