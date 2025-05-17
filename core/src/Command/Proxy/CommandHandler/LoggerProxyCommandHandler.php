<?php
declare(strict_types=1);

namespace Zinc\Core\Command\Proxy\CommandHandler;

use Psr\Log\LoggerInterface;
use Zinc\Core\Command\Command as C;
use Zinc\Core\Command\CommandHandler;
use Zinc\Core\Domain\Event\EventStream;
use Zinc\Core\Logging\Proxy\AbstractLoggingProxy;

final class LoggerProxyCommandHandler extends AbstractLoggingProxy implements CommandHandler
{
    /**
     * @param CommandHandler $inner
     * @param LoggerInterface $logger
     * @param string|null $message
     */
    public function __construct(
        private readonly CommandHandler $inner,
        private readonly LoggerInterface $logger,
        private readonly ?string $message = null,
    ) {}

    /**
     * @throws \Throwable
     */
    public function __invoke(C $command): void
    {
        $this->log(
            fn() => $this->inner->__invoke($command),
            $this->logger,
            $this->message ?? $this->inner::class
        );
    }
}