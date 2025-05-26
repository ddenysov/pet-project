<?php

declare(strict_types=1);

namespace Zinc\Core\Command\Decorator\CommandHandler;

use Zinc\Core\Command\CommandHandlerInterface;
use Zinc\Core\Command\CommandInterface;
use Zinc\Core\Logging\Logger;

class EventBusDecorator implements CommandHandlerInterface
{
    public function __construct(private CommandHandlerInterface $inner)
    {
    }

    public function __invoke(CommandInterface $command)
    {
        $result = $this->inner->__invoke($command);

        Logger::info('Publishing events start');
        Logger::info('Publishing events finished');

        return $result;
    }
}
