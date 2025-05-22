<?php

declare(strict_types=1);

namespace Zinc\Core\Logging\Strategy;

use Psr\Log\LoggerInterface;

final class ExecutionTimeStrategy implements LoggingStrategy
{
    private array $starts = [];

    public function before(object $svc, string $method, array $args, LoggerInterface $log): void
    {
        $this->starts[\spl_object_id($svc) . $method] = \microtime(true);
    }

    public function after(object $svc, string $method, array $args, mixed $result, LoggerInterface $log): void
    {
        $key   = \spl_object_id($svc) . $method;
        $start = $this->starts[$key] ?? null;
        if ($start !== null) {
            $t = (\microtime(true) - $start) * 1000;
            $log->info("{$method} executed in {$t} ms");
            unset($this->starts[$key]);
        }
    }

    public function error(object $svc, string $method, array $args, \Throwable $e, LoggerInterface $log): void
    {
        // та же история, но помечаем failure
        $this->after($svc, $method, $args, null, $log);
    }
}
