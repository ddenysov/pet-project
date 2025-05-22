<?php

declare(strict_types=1);

namespace Zinc\Core\Logging\Strategy;

use Psr\Log\LoggerInterface;

final class JsonPayloadStrategy implements LoggingStrategy
{
    public function before(object $svc, string $method, array $args, LoggerInterface $log): void
    {
        $log->debug("→ {$method}", ['payload' => \json_encode($args)]);
    }

    public function after(object $svc, string $method, array $args, mixed $result, LoggerInterface $log): void
    {
        $log->debug("← {$method}", ['result' => \json_encode($result)]);
    }

    public function error(object $svc, string $method, array $args, \Throwable $e, LoggerInterface $log): void
    {
        $log->error("✖ {$method}", ['exception' => $e]);
    }
}
