<?php

declare(strict_types=1);

namespace Zinc\Core\DataStore;

/**
 * Unified CRUD contract for any storage engine (SQL, NoSQL, KV, etc.).
 */
interface DataStoreInterface
{
    public function insert(string $collection, array $data): mixed;

    public function upsert(string $collection, Criteria $criteria, array $data): mixed;

    public function update(string $collection, Criteria $criteria, array $data): int;

    public function delete(string $collection, Criteria $criteria): int;

    /**
     * @return iterable<array>
     */
    public function find(string $collection, ?Criteria $criteria = null, ?QueryOptions $options = null): iterable;

    public function findOne(string $collection, Criteria $criteria, ?QueryOptions $options = null): ?array;

    public function transactional(callable $fn): mixed;

    public function inTransaction(): bool;
}
