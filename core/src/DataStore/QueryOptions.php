<?php

declare(strict_types=1);

namespace Zinc\Core\DataStore;

/**
 * Optional modifiers for a read query: sorting, pagination, projection.
 */
final class QueryOptions
{
    public function __construct(
        public readonly array $sort = [],
        public readonly ?int  $limit = null,
        public readonly ?int  $offset = null,
        public readonly ?array $select = null,
    ) {}

    public function withSort(string $field, string $direction = 'ASC'): self
    {
        $sort = $this->sort + [$field => \strtoupper($direction)];
        return new self($sort, $this->limit, $this->offset, $this->select);
    }

    public function withLimit(int $limit): self
    {
        return new self($this->sort, $limit, $this->offset, $this->select);
    }

    public function withOffset(int $offset): self
    {
        return new self($this->sort, $this->limit, $offset, $this->select);
    }

    public function withSelect(array $fields): self
    {
        return new self($this->sort, $this->limit, $this->offset, $fields);
    }

    public function getSort(): array
    {
        return $this->sort;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }

    public function getSelect(): ?array
    {
        return $this->select;
    }
}
