<?php

declare(strict_types=1);

namespace Zinc\Core\Command\Decorator;

use Zinc\Core\Command\CommandInterface;

class EventBusDecorator
{
    public function __construct(private mixed $inner)
    {
    }

    public function __invoke(CommandInterface $command)
    {
        $result = $this->inner->__invoke($command);
        echo 'START EVENT BUS COMMAND' . PHP_EOL;
        echo 'FINISH EVENT BUS COMMAND' . PHP_EOL;

        return $result;
    }
}
