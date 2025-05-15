<?php
declare(strict_types=1);

namespace Zinc\Core\Command;

/**
 * Middleware executed around command handling.
 */
interface MiddlewareInterface
{
    public function process(Command $command, callable $next): mixed;
}
