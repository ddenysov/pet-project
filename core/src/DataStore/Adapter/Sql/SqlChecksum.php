<?php
declare(strict_types=1);

namespace Zinc\Core\DataStore\Adapter\Sql;

/**
 * Calculate stable checksum for SQL migration to detect changes.
 */
final class SqlChecksum
{
    public static function hash(string $sql): string
    {
        $clean = preg_replace('/--.*?(\r?\n)|\/\*.*?\*\//s', '', $sql);
        $clean = preg_replace('/\s+/', ' ', trim($clean));
        return hash('sha256', $clean);
    }
}
