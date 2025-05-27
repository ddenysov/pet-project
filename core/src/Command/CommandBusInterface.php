<?php

declare(strict_types=1);

namespace Zinc\Core\Command;

/**
 * Dispatches Commands to their handlers.
 */
interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;
}
