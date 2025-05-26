<?php

declare(strict_types=1);

namespace Zinc\Core\Command\Decorator\CommandHandler;

use Zinc\Core\Command\CommandHandlerInterface;
use Zinc\Core\Command\CommandInterface;
use Zinc\Core\Logging\Logger;

class EventStoreDecorator implements CommandHandlerInterface
{
    private static $x = 0;

    public function __construct(private CommandHandlerInterface $inner)
    {
    }

    public function __invoke(CommandInterface $command)
    {
        $result = $this->inner->__invoke($command);

        Logger::info('Saving events to Event Store');
        self::$x++;
        if (self::$x < 2) {
            Logger::error('Events failed to save: Conflict');
            throw new \Exception('Failed');
        }
        Logger::info('Events saved');

        return $result;
    }
}
