<?php

declare(strict_types=1);

namespace Zinc\Core\DataStore\Bridge\PDO;

/**
 * Insert many rows efficiently using multi‑value syntax.
 */
final class BulkInserter
{
    public function __construct(private PdoDataStore $store) {}

    /**
     * @param array<int,array<string,mixed>> $rows
     */
    public function insertMany(string $table, array $rows): int
    {
        if (!$rows) {
            return 0;
        }

        $cols = \array_keys($rows[0]);
        $pdo  = (new \ReflectionClass($this->store))->getProperty('pdo')->getValue($this->store);

        $valuesPlaceholder = '(' . \implode(',', \array_fill(0, \count($cols), '?')) . ')';
        $sql = \sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->store->q($table),
            \implode(',', \array_map([$this->store,'q'], $cols)),
            \implode(',', \array_fill(0, \count($rows), $valuesPlaceholder)),
        );
        $bind = [];
        foreach ($rows as $r) {
            foreach ($cols as $c) {
                $bind[] = $r[$c];
            }
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($bind);
        return $stmt->rowCount();
    }
}
