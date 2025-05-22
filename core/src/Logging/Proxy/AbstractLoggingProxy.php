<?php

declare(strict_types=1);

namespace Zinc\Core\Logging\Proxy;

use Psr\Log\LoggerInterface;

abstract class AbstractLoggingProxy
{
    /**
     * @throws \Throwable
     */
    public function log(callable $callback, LoggerInterface $logger, string $message, array $context = []): mixed
    {
        $logger->info('START: ' . $message, $context);
        try {
            $result = $callback();
            $logger->info('FINISH: ' . $message, $context);

            return $result;
        } catch (\Throwable $e) {
            $logger->error('ERROR: ' . $message, $context);

            throw $e;
        }
    }
}
