<?php

declare(strict_types=1);

namespace Zinc\Core\Command\Decorator\CommandHandler;

use Zinc\Core\Command\CommandHandlerInterface;
use Zinc\Core\Command\CommandInterface;

class EventStoreDecorator implements CommandHandlerInterface
{
    private static $x = 0;

    public function __construct(private CommandHandlerInterface $inner)
    {
    }

    public function __invoke(CommandInterface $command)
    {
        self::$x++;
        if (self::$x < 2) {
            throw new \Exception('Failed');
        }
        $result = $this->inner->__invoke($command);

        return $result;
    }
}
