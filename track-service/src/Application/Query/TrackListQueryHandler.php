<?php

namespace Track\Application\Query;

use Psr\Log\LoggerInterface;
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
     * @param TrackListQueryHandler $query
     * @return TrackListQueryResult
     */
    public function __invoke(TrackListQueryHandler $query): TrackListQueryResult
    {
        $this->logger->info('Query: Healthcheck OK', [
            $query->timestamp,
        ]);

        return new TrackListQueryResult();
    }
}