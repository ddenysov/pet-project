<?php

declare(strict_types=1);

namespace Zinc\Core\Command\Proxy;

use Psr\Log\LoggerInterface;
use Zinc\Core\Command\Command as C;
use Zinc\Core\Command\CommandHandler;
use Zinc\Core\Command\CommandHandlerInterface;
use Zinc\Core\Command\CommandInterface;
use Zinc\Core\Logging\Proxy\AbstractLoggingProxy;

final class LoggerProxyCommandHandler extends AbstractLoggingProxy implements CommandHandler
{
    public function __construct(
        private readonly CommandHandlerInterface $inner,
        private readonly LoggerInterface $logger,
        private readonly \Closure $begin,
        private readonly \Closure $end,
    ) {}

    /**
     * @throws \Throwable
     */
    public function __invoke(CommandInterface $command): void
    {
        $this->begin($command);
        $this->log(
            fn() => $this->inner->__invoke($command),
            $this->logger,
            $this->message ?? $this->inner::class,
        );
    }
}
