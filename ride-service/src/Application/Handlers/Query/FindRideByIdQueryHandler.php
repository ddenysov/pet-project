<?php

namespace Ride\Application\Handlers\Query;

use Common\Application\QueryBuilder\Port\QueryBuilder;
use Psr\Log\LoggerInterface;

class FindRideByIdQueryHandler
{
    /**
     * @param LoggerInterface $logger
     * @param RideView $view
     */
    public function __construct(private LoggerInterface $logger, private QueryBuilder $queryBuilder)
    {
    }

    /**
     * @param FindRideByIdQuery $query
     * @return RideView
     */
    public function __invoke(FindRideByIdQuery $query): RideView
    {
        $ride = $this->queryBuilder->table('ride')->id($query->id);

        return new RideView($ride);
    }
}