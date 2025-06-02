<?php

declare(strict_types=1);

namespace Zinc\Core\DataStore\Bridge\PDO\Dialect;

final class MySqlDialect implements Dialect
{
    public function name(): string
    {
        return 'mysql';
    }

    public function quote(string $identifier): string
    {
        return '`' . \str_replace('`', '``', $identifier) . '`';
    }

    public function regexOperator(): ?string
    {
        return 'REGEXP';
    }
}
