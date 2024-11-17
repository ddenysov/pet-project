<?php

namespace Common\Application\Handlers\Query;

class PaginatedQuery extends Query
{
    public function __construct(
        private ?int    $page = 1,
        private ?int    $pageSize = 5,
        private ?array  $filters = [],
        private ?string $orderBy = null,
        private ?string $orderDir = 'asc',
        private ?string $search = null,
        private ?bool   $useCount = false,
    )
    {
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }

    public function getOrderDir(): ?string
    {
        return $this->orderDir;
    }

    public function getSearch(): ?string
    {
        return $this->search;
    }

    public function getUseCount(): ?bool
    {
        return $this->useCount;
    }
}