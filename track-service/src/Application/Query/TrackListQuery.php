<?php

namespace Track\Application\Query;

use Common\Application\Handlers\Query\Port\Query;

class TrackListQuery implements Query
{
    public function __construct(
        private ?int    $page = 1,
        private ?int    $pageSize = 5,
        private ?array  $filters = [],
        private ?array  $sort = ['name' => 'ASC'],
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

    public function getSort(): array
    {
        return $this->sort;
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