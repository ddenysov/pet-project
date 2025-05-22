<?php

declare(strict_types=1);

namespace Zinc\Core\Logging\Strategy;

use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;

final class CorrelationIdStrategy implements LoggingStrategy
{
    private string $cid;

    public function __construct()
    {
        $this->cid = Uuid::uuid4()->toString();
    }

    public function before(object $svc, string $method, array $args, LoggerInterface $log): void
    {
        $log->withScope(fn() => $log->info("cid={$this->cid} START {$method}"));
    }

    public function after(object $svc, string $method, array $args, mixed $result, LoggerInterface $log): void
    {
        $log->withScope(fn() => $log->info("cid={$this->cid} END   {$method}"));
    }

    public function error(object $svc, string $method, array $args, \Throwable $e, LoggerInterface $log): void
    {
        $log->withScope(fn() => $log->error("cid={$this->cid} ERR  {$method}", ['ex' => $e]));
    }
}
