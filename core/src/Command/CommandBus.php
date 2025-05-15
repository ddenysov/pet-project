<?php
declare(strict_types=1);

namespace Zinc\Core\Command;

/**
 * Dispatches Commands to their handlers.
 */
interface CommandBus
{
    public function dispatch(Command $command): mixed;
}
