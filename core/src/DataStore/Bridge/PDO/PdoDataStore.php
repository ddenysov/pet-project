<?php

declare(strict_types=1);

namespace Zinc\Core\DataStore\Bridge\PDO;

use PDO;
use Zinc\Core\DataStore\{Bridge\PDO\Dialect\SqliteDialect,
    Bridge\PDO\SqlCriteriaCompiler,
    Bridge\PDO\StatementCache,
    Criteria,
    DataStoreInterface,
    QueryOptions
};
use Zinc\Core\DataStore\Bridge\PDO\Dialect\Dialect;
use Zinc\Core\Logging\Logger;

/**
 * PDO‑based DataStore implementation.
 */
final class PdoDataStore implements DataStoreInterface
{
    private \PDO $pdo;

    public function __construct(
        private Dialect             $dialect = new SqliteDialect(),
        private StatementCache      $stmtCache = new StatementCache(),
        private SqlCriteriaCompiler $compiler = new SqlCriteriaCompiler(),
    )
    {
        $this->pdo = new \PDO('sqlite:/app/var/demo.db', null, null, [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ]);
    }

    /*------------------------- CRUD -------------------------*/

    public function insert(string $collection, array $data): mixed
    {
        $cols  = \array_keys($data);
        $place = \array_map(static fn ($c) => ':' . $c, $cols);

        $sql = \sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->q($collection),
            \implode(',', \array_map([$this, 'q'], $cols)),
            \implode(',', $place),
        );
        $this->exec($sql, $data);
        return $this->pdo->lastInsertId();
    }

    public function upsert(string $collection, Criteria $c, array $data): mixed
    {
        return $this->update($collection, $c, $data) ?: $this->insert($collection, $data);
    }

    public function update(string $collection, Criteria $c, array $data): int
    {
        $set = \implode(', ', \array_map(
            fn ($k) => $this->q($k) . ' = :' . $k,
            \array_keys($data),
        ));
        [$where, $params] = $this->compiler->compile($c, $this->dialect);
        $sql = \sprintf('UPDATE %s SET %s WHERE %s', $this->q($collection), $set, $where);
        return $this->exec($sql, $data + $params)->rowCount();
    }

    public function delete(string $collection, Criteria $c): int
    {
        [$w, $p] = $this->compiler->compile($c, $this->dialect);
        $sql = \sprintf('DELETE FROM %s WHERE %s', $this->q($collection), $w);
        return $this->exec($sql, $p)->rowCount();
    }

    public function find(string $collection, ?Criteria $criteria = null, ?QueryOptions $options = null): iterable
    {
        $sql = 'SELECT ';
        $sql .= $options?->select ? \implode(',', \array_map([$this, 'q'], $options->select)) : '*';

        if (is_null($criteria)) {
            $p   = [];
            $sql .= ' FROM ' . $this->q($collection);
        } else {
            [$w, $p] = $this->compiler->compile($criteria, $this->dialect);
            $sql .= ' FROM ' . $this->q($collection) . ' WHERE ' . $w;
        }


        if ($options?->sort) {
            $order = [];
            foreach ($options->sort as $f => $dir) {
                $order[] = $this->q($f) . ' ' . $dir;
            }
            $sql .= ' ORDER BY ' . \implode(',', $order);
        }
        if ($options?->limit !== null) {
            $sql .= ' LIMIT ' . $options->limit;
        }
        if ($options?->offset !== null) {
            $sql .= ' OFFSET ' . $options->offset;
        }

        return $this->exec($sql, $p)->fetchAll();
    }

    public function findOne(string $collection, Criteria $criteria, ?QueryOptions $options = null): ?array
    {
        foreach ($this->find($collection, $criteria, new QueryOptions(limit: 1)) as $row) {
            return $row;
        }
        return null;
    }

    /*-------------------- Transaction --------------------*/

    public function transactional(callable $fn): mixed
    {
        $this->pdo->beginTransaction();
        try {
            $r = $fn($this);
            $this->pdo->commit();
            return $r;
        } catch (\Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function inTransaction(): bool
    {
        return $this->pdo->inTransaction();
    }

    /*-------------------- Helpers --------------------*/

    public function q(string $id): string
    {
        return $this->dialect->quote($id);
    }

    public function exec(string $sql, array $params = []): \PDOStatement
    {
        Logger::debug('Query', [
            'sql'    => $sql,
            'params' => $params,
        ]);
        $stmt = $this->stmtCache->prepare($this->pdo, $sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue(\is_int($k) ? $k + 1 : $k, $v);
        }
        if (!$stmt->execute()) {
            throw new DataStoreException('SQL failed: ' . $sql);
        }
        return $stmt;
    }
}
