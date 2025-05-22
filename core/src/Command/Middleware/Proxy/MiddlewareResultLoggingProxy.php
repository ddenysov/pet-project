<?php

declare(strict_types=1);

namespace Zinc\Core\Command\Middleware\Proxy;

use Psr\Log\LoggerInterface;
use Zinc\Core\Command\Command;
use Zinc\Core\Command\Middleware\CommandHandlerMiddleware;
use Zinc\Core\Logging\Proxy\AbstractLoggingProxy;

class MiddlewareResultLoggingProxy extends AbstractLoggingProxy implements CommandHandlerMiddleware
{
    public function __construct(
        private readonly CommandHandlerMiddleware $inner,
        private readonly LoggerInterface          $logger,
        private readonly ?string                  $message = null,
    ) {}

    #[\Override]
    public function handle(Command $command, callable $next): mixed
    {
        $this->before($command);

        return  $this->after($command, $next($command));
    }

    #[\Override]
    public function before(Command $command)
    {
        return $this->inner->before($command);
    }

    #[\Override]
    public function after(Command $command, mixed $result): mixed
    {
        return $this->log(
            fn() => $this->inner->after($command, $result),
            $this->logger,
            $this->message ?? $this->inner::class,
            [
                'command' => $command->toArray(),
            ],
        );
    }
}
