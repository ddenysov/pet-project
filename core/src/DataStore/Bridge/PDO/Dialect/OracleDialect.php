<?php

declare(strict_types=1);

namespace Zinc\Core\DataStore\Bridge\PDO\Dialect;

final class OracleDialect implements Dialect
{
    public function name(): string
    {
        return 'oci';
    }

    public function quote(string $identifier): string
    {
        return '"' . \strtoupper($identifier) . '"';
    }

    public function regexOperator(): ?string
    {
        return null;
    }
}
