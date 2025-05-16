<?php
declare(strict_types=1);

namespace Zinc\Core\Command\Middleware;

use Zinc\Core\Command\Command;
use Zinc\Core\Command\Command as C;

abstract class AbstractCommandHandlerMiddleware implements CommandHandlerMiddleware
{
    #[\Override] final public function handle(C $command, callable $next): mixed
    {
        $this->before($command);

        return  $this->after($command, $next($command));
    }

    public function before(C $command)
    {

    }

    public function after(C $command, mixed $result): mixed
    {
        return $result;
    }
}