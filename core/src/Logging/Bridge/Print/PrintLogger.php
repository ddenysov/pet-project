<?php

declare(strict_types=1);

namespace Zinc\Core\Logging\Bridge\Print;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class PrintLogger implements LoggerInterface
{
    #[\Override]
    public function emergency($message, array $context = []): void
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    #[\Override]
    public function alert($message, array $context = []): void
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    #[\Override]
    public function critical($message, array $context = []): void
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    #[\Override]
    public function error($message, array $context = []): void
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    #[\Override]
    public function warning($message, array $context = []): void
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    #[\Override]
    public function notice($message, array $context = []): void
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    #[\Override]
    public function info($message, array $context = []): void
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    #[\Override]
    public function debug($message, array $context = []): void
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }

    #[\Override]
    public function log($level, $message, array $context = []): void
    {
        $output = \sprintf("%s [%s] %s", \date('Y-m-d H:i:s'), \strtoupper($level), (string) $message);
        echo $output . ' ' . \json_encode($context, JSON_PRETTY_PRINT) . PHP_EOL;
    }
}
