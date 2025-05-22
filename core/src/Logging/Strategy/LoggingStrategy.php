<?php

declare(strict_types=1);

namespace Zinc\Core\Logging\Strategy;

use Psr\Log\LoggerInterface;

interface LoggingStrategy
{
    public function before(object $svc, string $method, array $args, LoggerInterface $log): void;

    public function after(object $svc, string $method, array $args, mixed $result, LoggerInterface $log): void;

    public function error(object $svc, string $method, array $args, \Throwable $e, LoggerInterface $log): void;
}
