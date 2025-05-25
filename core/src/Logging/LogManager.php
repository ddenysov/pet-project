<?php

declare(strict_types=1);

namespace Zinc\Core\Logging;

use Psr\Log\LoggerInterface;

class LogManager implements LoggerInterface
{
    public function __construct(private LoggerInterface $logger) {}

    #[\Override] public function emergency(\Stringable|string $message, array $context = []): void
    {
        // TODO: Implement emergency() method.
    }

    #[\Override] public function alert(\Stringable|string $message, array $context = []): void
    {
        // TODO: Implement alert() method.
    }

    #[\Override] public function critical(\Stringable|string $message, array $context = []): void
    {
        // TODO: Implement critical() method.
    }

    #[\Override] public function error(\Stringable|string $message, array $context = []): void
    {
        // TODO: Implement error() method.
    }

    #[\Override] public function warning(\Stringable|string $message, array $context = []): void
    {
        // TODO: Implement warning() method.
    }

    #[\Override] public function notice(\Stringable|string $message, array $context = []): void
    {
        // TODO: Implement notice() method.
    }

    #[\Override] public function info(\Stringable|string $message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }

    #[\Override] public function debug(\Stringable|string $message, array $context = []): void
    {
        $this->logger->debug($message, $context);
    }

    #[\Override] public function log($level, \Stringable|string $message, array $context = []): void
    {
        $this->logger->log($level, $message, $context);
    }
}
