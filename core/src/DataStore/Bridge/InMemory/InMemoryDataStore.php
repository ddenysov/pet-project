<?php

declare(strict_types=1);

namespace Zinc\Core\DataStore\Bridge\InMemory;

use Zinc\Core\DataStore\DataStore;
use Zinc\Core\DataStore\Criteria;
use Zinc\Core\DataStore\DataStoreInterface;
use Zinc\Core\DataStore\QueryOptions;

/**
 * Very simple in-memory implementation of the DataStore contract.
 * ⚠️ NOT thread-safe and intended only for tests or prototyping.
 */
class InMemoryDataStore implements DataStoreInterface
{
    /** @var array<string, array<int, array>> Collections indexed by name */
    private array $collections = [];

    /** @var bool Flag indicating an active transaction */
    private bool $inTransaction = false;

    /** @var array<string, array<int, array>> Backup taken at transaction start */
    private array $transactionBackup = [];

    public function insert(string $collection, array $data): mixed
    {
        $this->collections[$collection][] = $data;

        return $data; // Return inserted row for convenience.
    }

    public function upsert(string $collection, Criteria $criteria, array $data): mixed
    {
        $updated = false;

        foreach ($this->collections[$collection] ?? [] as $idx => $row) {
            if ($this->matches($criteria, $row)) {
                $this->collections[$collection][$idx] = \array_merge($row, $data);
                $updated = true;
            }
        }

        if (!$updated) {
            $this->insert($collection, $data);
        }

        return $data;
    }

    public function update(string $collection, Criteria $criteria, array $data): int
    {
        $count = 0;

        foreach ($this->collections[$collection] ?? [] as $idx => $row) {
            if ($this->matches($criteria, $row)) {
                $this->collections[$collection][$idx] = \array_merge($row, $data);
                ++$count;
            }
        }

        return $count;
    }

    public function delete(string $collection, Criteria $criteria): int
    {
        $count = 0;

        foreach ($this->collections[$collection] ?? [] as $idx => $row) {
            if ($this->matches($criteria, $row)) {
                unset($this->collections[$collection][$idx]);
                ++$count;
            }
        }

        return $count;
    }

    /**
     * @return iterable<array>
     */
    public function find(string $collection, ?Criteria $criteria = null, ?QueryOptions $options = null): iterable
    {
        $results = [];

        foreach ($this->collections[$collection] ?? [] as $row) {
            if ($this->matches($criteria, $row)) {
                $results[] = $row;
            }
        }

        if ($options !== null) {
            $results = $this->applyOptions($results, $options);
        }

        return $results;
    }

    public function findOne(string $collection, Criteria $criteria, ?QueryOptions $options = null): ?array
    {
        foreach ($this->collections[$collection] ?? [] as $row) {
            if ($this->matches($criteria, $row)) {
                return $row;
            }
        }

        return null;
    }

    public function transactional(callable $fn): mixed
    {
        if ($this->inTransaction) {
            // Nested transaction — just execute.
            return $fn($this);
        }

        $this->inTransaction   = true;
        $this->transactionBackup = $this->collections;

        try {
            $result               = $fn($this);
            $this->inTransaction  = false;
            $this->transactionBackup = [];

            return $result;
        } catch (\Throwable $e) {
            // Rollback to snapshot.
            $this->collections      = $this->transactionBackup;
            $this->transactionBackup = [];
            $this->inTransaction    = false;

            throw $e;
        }
    }

    public function inTransaction(): bool
    {
        return $this->inTransaction;
    }

    // ---------------------------------------------------------------------
    // Helpers
    // ---------------------------------------------------------------------

    /**
     * Checks whether a row satisfies the passed Criteria.
     * Falls back to naive equality if Criteria has no matcher.
     */
    private function matches(?Criteria $criteria, array $row): bool
    {
        if (!$criteria) {
            return true;
        }
        // Preferred: delegated evaluation.
        if (\method_exists($criteria, 'matches')) {
            /** @phpstan-ignore-next-line */
            return $criteria->matches($row);
        }

        // Fallback: basic equality on an associative filter array.
        if (\method_exists($criteria, 'toArray')) {
            /** @var array<string, mixed> $filter */
            $filter = $criteria->toArray();
            foreach ($filter as $field => $expectedValue) {
                if (!\array_key_exists($field, $row) || $row[$field] !== $expectedValue) {
                    return false;
                }
            }

            return true;
        }

        // Unknown criteria implementation — accept all rows.
        return true;
    }

    /**
     * Applies limit/offset/sort options if they exist on QueryOptions.
     *
     * @param array<int, array> $rows
     * @return array<int, array>
     */
    private function applyOptions(array $rows, QueryOptions $options): array
    {
        // Sorting.
        if (\method_exists($options, 'getSort')) {
            /** @var array<string, string>|null $sort */
            $sort = $options->getSort();
            if ($sort !== null) {
                foreach (\array_reverse($sort) as $field => $dir) {
                    \usort(
                        $rows,
                        static fn(array $a, array $b): int =>
                        \strtoupper($dir) === 'DESC'
                            ? $b[$field] <=> $a[$field]
                            : $a[$field] <=> $b[$field],
                    );
                }
            }
        }

        // Offset.
        if (\method_exists($options, 'getOffset')) {
            $rows = \array_slice($rows, (int) $options->getOffset());
        }

        // Limit.
        if (\method_exists($options, 'getLimit') && ($limit = (int) $options->getLimit()) > 0) {
            $rows = \array_slice($rows, 0, $limit);
        }

        return $rows;
    }
}
