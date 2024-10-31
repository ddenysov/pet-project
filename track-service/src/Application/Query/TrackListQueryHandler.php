<?php

namespace Track\Application\Query;

use Psr\Log\LoggerInterface;
use Track\Application\Query\Port\TrackQueryBuilder;
use Track\Application\Query\Projection\HealthCheck;

class TrackListQueryHandler
{
    /**
     * @param LoggerInterface $logger
     */
    public function __construct(private LoggerInterface $logger)
    {
    }

    /**
     * @param TrackQueryBuilder $query
     * @return TrackListQueryResult
     */
    public function __invoke(TrackQueryBuilder $query): TrackListQueryResult
    {
        $this->logger->info('Query: Healthcheck OK', [
            $query->timestamp,
        ]);

        return new TrackListQueryResult();
    }
}