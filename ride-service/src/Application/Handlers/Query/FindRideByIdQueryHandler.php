<?php

namespace Ride\Application\Handlers\Query;

use Common\Application\QueryBuilder\Port\QueryBuilder;
use Common\Delivery\Http\Security\Identity;
use Psr\Log\LoggerInterface;

class FindRideByIdQueryHandler
{
    /**
     * @param LoggerInterface $logger
     * @param QueryBuilder $queryBuilder
     * @param Identity $identity
     */
    public function __construct(
        private LoggerInterface $logger,
        private QueryBuilder $queryBuilder,
        private Identity $identity,
    )
    {
    }

    /**
     * @param FindRideByIdQuery $query
     * @return RideView
     */
    public function __invoke(FindRideByIdQuery $query): RideView
    {
        $ride = $this->queryBuilder
            ->table('ride')
            ->id($query->id);

        return new RideView($ride, $this->identity);
    }
}