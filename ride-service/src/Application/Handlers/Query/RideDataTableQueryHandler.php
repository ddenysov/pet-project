<?php

namespace Ride\Application\Handlers\Query;

use Common\Application\Handlers\Query\Handler\PaginatedCollectionHandler;
use Common\Application\Handlers\Query\Result\PaginatedCollectionResult;
use Common\Application\QueryBuilder\Port\QueryBuilder;
use Common\Delivery\Http\Security\Identity;
use Psr\Log\LoggerInterface;
use Ride\Application\Handlers\Query\Projection\HealthCheck;

class RideDataTableQueryHandler
{
    /**
     * @param LoggerInterface $logger
     * @param QueryBuilder $queryBuilder
     * @param Identity $identity
     * @param PaginatedCollectionHandler $collectionHandler
     */
    public function __construct(
        private LoggerInterface $logger,
        private QueryBuilder $queryBuilder,
        private Identity $identity,
        private PaginatedCollectionHandler $collectionHandler,
    )
    {
    }

    public function __invoke(RideDataTableQuery $query): PaginatedCollectionResult
    {
        return $this->collectionHandler->handle($query, $this->queryBuilder, 'ride');
    }
}