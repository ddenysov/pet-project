<?php

declare(strict_types=1);

namespace Zinc\Core\Command\Decorator;

use Zinc\Core\Command\CommandInterface;

class RetryDecorator
{
    public function __construct(private mixed $inner)
    {
    }

    public function __invoke(CommandInterface $command)
    {
        echo 'START RETRY COMMAND' . PHP_EOL;
        $result = $this->inner->__invoke($command);
        echo 'FINISH RETRY COMMAND' . PHP_EOL;

        return $result;
    }
}
