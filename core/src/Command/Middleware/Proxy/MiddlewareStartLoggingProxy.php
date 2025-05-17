<?php
declare(strict_types=1);

namespace Zinc\Core\Command\Middleware\Proxy;

use Psr\Log\LoggerInterface;
use Zinc\Core\Command\Command;
use Zinc\Core\Command\Middleware\CommandHandlerMiddleware;
use Zinc\Core\Logging\Proxy\AbstractLoggingProxy;

class MiddlewareStartLoggingProxy extends AbstractLoggingProxy implements CommandHandlerMiddleware
{
    /**
     * @param CommandHandlerMiddleware $inner
     * @param LoggerInterface $logger
     * @param string|null $message
     */
    public function __construct(
        private readonly CommandHandlerMiddleware $inner,
        private readonly LoggerInterface          $logger,
        private readonly ?string                  $message = null,
    ) {
    }

    #[\Override] public function handle(Command $command, callable $next): mixed
    {
        $this->before($command);

        return  $this->after($command, $next($command));
    }

    #[\Override] public function before(Command $command)
    {
        return $this->log(
            fn () => $this->inner->before($command),
            $this->logger,
            $this->message ?? $this->inner::class,
            [
                'command' => $command->toArray(),
            ]
        );
    }

    #[\Override] public function after(Command $command, mixed $result): mixed
    {
        return $this->inner->after($command, $result);
    }
}