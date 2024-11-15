<?php

namespace Track\Application\Query;

use Common\Application\Handlers\Query\Handler\PaginatedCollectionHandler;
use Common\Application\Handlers\Query\Result\PaginatedCollectionResult;
use Psr\Log\LoggerInterface;
use Track\Application\Query\Port\TrackQueryBuilder;

class TrackListQueryHandler
{
    /**
     * @param LoggerInterface $logger
     * @param PaginatedCollectionHandler $collectionHandler
     * @param TrackQueryBuilder $queryBuilder
     */
    public function __construct(
        private LoggerInterface $logger,
        private PaginatedCollectionHandler $collectionHandler,
        private TrackQueryBuilder $queryBuilder,
    )
    {
    }

    /**
     * @param TrackListQuery $query
     * @return PaginatedCollectionResult
     */
    public function __invoke(TrackListQuery $query): PaginatedCollectionResult
    {
        return $this->collectionHandler->handle($query, $this->queryBuilder, 'track');
    }
}