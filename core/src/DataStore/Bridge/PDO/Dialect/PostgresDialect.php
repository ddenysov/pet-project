<?php

declare(strict_types=1);

namespace Zinc\Core\DataStore\Bridge\PDO\Dialect;

final class PostgresDialect implements Dialect
{
    public function name(): string
    {
        return 'pgsql';
    }

    public function quote(string $identifier): string
    {
        return '"' . \str_replace('"', '""', $identifier) . '"';
    }

    public function regexOperator(): ?string
    {
        return '~';
    }
}
