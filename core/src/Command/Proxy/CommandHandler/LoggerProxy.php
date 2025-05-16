<?php
declare(strict_types=1);

namespace Zinc\Core\Command\Proxy\CommandHandler;

use Psr\Log\LoggerInterface;
use Zinc\Core\Command\Command as C;
use Zinc\Core\Command\CommandHandler;
use Zinc\Core\Logging\Proxy\AbstractLoggingProxy;

final class LoggerProxy extends AbstractLoggingProxy implements CommandHandler
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

    public function __invoke(C $command): mixed
    {
        return $this->log(
            fn() => $this->inner->__invoke($command),
            $this->logger,
            $this->message ?? $this->inner::class
        );
    }
}