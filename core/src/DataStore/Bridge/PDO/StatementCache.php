<?php

declare(strict_types=1);

namespace Zinc\Core\DataStore\Bridge\PDO;

/**
 * Minimal LRU cache for prepared statements.
 */
final class StatementCache
{
    /** @var array<string, \PDOStatement> */
    private array $cache = [];

    private int $max = 128;

    public function prepare(\PDO $pdo, string $sql): \PDOStatement
    {
        if (isset($this->cache[$sql])) {
            return $this->cache[$sql];
        }
        if (\count($this->cache) >= $this->max) {
            \array_shift($this->cache);
        }
        return $this->cache[$sql] = $pdo->prepare($sql);
    }
}
