<?php

declare(strict_types=1);

namespace Zinc\Core\Command\Middleware;

use Zinc\Core\Command\Command;
use Zinc\Core\Command\Command as C;

interface CommandHandlerMiddleware
{
    public function handle(Command $command, callable $next): mixed;

    public function before(C $command);

    public function after(C $command, mixed $result): mixed;
}
