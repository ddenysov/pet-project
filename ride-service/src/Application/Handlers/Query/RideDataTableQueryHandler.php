<?php

namespace Ride\Application\Handlers\Query;

use Common\Application\QueryBuilder\Port\QueryBuilder;
use Psr\Log\LoggerInterface;
use Ride\Application\Handlers\Query\Projection\HealthCheck;

class RideDataTableQueryHandler
{
    /**
     * @param LoggerInterface $logger
     * @param RideView $view
     */
    public function __construct(private LoggerInterface $logger, private QueryBuilder $queryBuilder)
    {
    }

    public function __invoke(RideDataTableQuery $query)
    {
        $rides = $this->queryBuilder->table('ride')->orderBy('created_at', 'desc')->get();

        return RideView::collection($rides);
    }
}