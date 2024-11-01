<?php

namespace Track\Application\Query;

use Psr\Log\LoggerInterface;
use Track\Application\Query\Port\TrackQueryBuilder;

class TrackListQueryHandler
{
    /**
     * @param LoggerInterface $logger
     * @param TrackQueryBuilder $queryBuilder
     */
    public function __construct(
        private LoggerInterface $logger,
        private TrackQueryBuilder $queryBuilder
    )
    {
    }

    /**
     * @param TrackQueryBuilder $query
     * @return TrackListQueryResult
     */
    public function __invoke(TrackListQuery $query): array
    {
        return $this->queryBuilder->from('track')
            ->limit($query->getPageSize())
            ->offset(($query->getPage() - 1) * $query->getPageSize())
            ->get();
    }
}