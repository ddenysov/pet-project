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
        $total = $this->createQueryBuilder($query, $queryBuilder, $table)->count();
        $dbQuery = $this->createQueryBuilder($query, $queryBuilder, $table)
            ->limit($query->getPageSize())
            ->offset(($query->getPage() - 1) * $query->getPageSize());

        if ($query->getOrderBy()) {
            $dbQuery->orderBy($query->getOrderBy(), $query->getOrderDir());
        }

        return new PaginatedCollectionResult(
            collection:  $dbQuery->get(),
            total: $total,
        );
    }

    /**
     * @param PaginatedQuery $query
     * @param QueryBuilder $queryBuilder
     * @param string $table
     * @return QueryBuilder
     */
    private function createQueryBuilder(PaginatedQuery $query, QueryBuilder $queryBuilder, string $table): QueryBuilder
    {
        $builder = $queryBuilder->from($table);

        if ($query->getFilters()) {
            foreach ($query->getFilters() as $filter) {
                $builder->where($filter[0], '=', $filter[1]);
            }
        }

        return $builder;
    }
}