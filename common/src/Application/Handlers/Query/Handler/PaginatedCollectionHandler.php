<?php

namespace Common\Application\Handlers\Query\Handler;

use Common\Application\Handlers\Query\PaginatedQuery;
use Common\Application\Handlers\Query\Result\PaginatedCollectionResult;
use Common\Application\QueryBuilder\Port\QueryBuilder;

class PaginatedCollectionHandler
{
    /**
     * @param PaginatedQuery $query
     * @param QueryBuilder $queryBuilder
     * @param string $table
     * @return PaginatedCollectionResult
     */
    public function handle(PaginatedQuery $query, QueryBuilder $queryBuilder, string $table)
    {
        $builder = $queryBuilder->from($table)
            ->limit($query->getPageSize())
            ->offset(($query->getPage() - 1) * $query->getPageSize());

        if ($query->getFilters()) {
            foreach ($query->getFilters() as $filter) {
                $builder->where($filter[0], '=', $filter[1]);
            }
        }

        return new PaginatedCollectionResult(
            collection:  $builder->get(),
            total: $builder->count(),
        );
    }
}