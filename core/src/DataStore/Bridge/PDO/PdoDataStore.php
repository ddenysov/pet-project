<?php
declare(strict_types=1);

namespace Zinc\Core\DataStore\Adapter\PDO;

use PDO;
use PDOStatement;
use Zinc\Core\DataStore\{DataStore, Criteria, QueryOptions};
use Zinc\Core\DataStore\Adapter\PDO\Dialect\Dialect;
use Zinc\Core\DataStore\Exception\DataStoreException;

/**
 * PDO‑based DataStore implementation.
 */
final class PdoDataStore implements DataStore
{
    public function __construct(
        private PDO               $pdo,
        private Dialect           $dialect,
        private StatementCache    $stmtCache = new StatementCache(),
        private SqlCriteriaCompiler $compiler = new SqlCriteriaCompiler(),
    ) {}

    /*------------------------- CRUD -------------------------*/

    public function insert(string $collection, array $data): mixed
    {
        $cols = array_keys($data);
        $place = array_map(fn($c) => ':' . $c, $cols);

        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->q($collection),
            implode(',', array_map([$this,'q'],$cols)),
            implode(',', $place),
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
        $set = implode(', ', array_map(
            fn($k) => $this->q($k) . ' = :' . $k,
            array_keys($data)
        ));
        [$where,$params] = $this->compiler->compile($c, $this->dialect);
        $sql = sprintf('UPDATE %s SET %s WHERE %s', $this->q($collection), $set, $where);
        return $this->exec($sql, $data + $params)->rowCount();
    }

    public function delete(string $collection, Criteria $c): int
    {
        [$w,$p] = $this->compiler->compile($c, $this->dialect);
        $sql = sprintf('DELETE FROM %s WHERE %s', $this->q($collection), $w);
        return $this->exec($sql, $p)->rowCount();
    }

    public function find(string $collection, Criteria $c, ?QueryOptions $o=null): iterable
    {
        [$w,$p] = $this->compiler->compile($c, $this->dialect);

        $sql = 'SELECT ';
        $sql .= $o?->select ? implode(',', array_map([$this,'q'],$o->select)) : '*';
        $sql .= ' FROM ' . $this->q($collection) . ' WHERE ' . $w;

        if ($o?->sort) {
            $order = [];
            foreach ($o->sort as $f=>$dir) $order[] = $this->q($f).' '.$dir;
            $sql .= ' ORDER BY '.implode(',', $order);
        }
        if ($o?->limit !== null)  $sql .= ' LIMIT '.$o->limit;
        if ($o?->offset !== null) $sql .= ' OFFSET '.$o->offset;

        return $this->exec($sql, $p);
    }

    public function findOne(string $collection, Criteria $c): ?array
    {
        foreach ($this->find($collection, $c, new QueryOptions(limit:1)) as $row) return $row;
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

    public function inTransaction(): bool { return $this->pdo->inTransaction(); }

    /*-------------------- Helpers --------------------*/

    public function q(string $id): string { return $this->dialect->quote($id);}
    public function exec(string $sql, array $params=[]): PDOStatement
    {
        $stmt = $this->stmtCache->prepare($this->pdo, $sql);
        foreach ($params as $k=>$v) $stmt->bindValue(is_int($k)?$k+1:$k, $v);
        if (!$stmt->execute()) {
            throw new DataStoreException('SQL failed: '.$sql);
        }
        return $stmt;
    }
}
