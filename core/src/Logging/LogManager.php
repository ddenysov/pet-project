<?php
declare(strict_types=1);

namespace Zinc\Core\Logging;

use Psr\Log\LoggerInterface;

class LogManager
{

    public function __construct(private LoggerInterface $logger)
    {
    }

    public function log(callable $callback, string $message, array $context = []): mixed
    {
        $this->logger->info('START: ' . $message, $context);
        try {
            $result = $callback();
            $this->logger->info('FINISH: ' . $message, $context);

            return $result;
        } catch (\Throwable $e) {
            $this->logger->error('ERROR: ' . $message, $context);

            throw $e;
        }
    }
}