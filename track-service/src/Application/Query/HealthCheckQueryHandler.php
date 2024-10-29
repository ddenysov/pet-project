<?php

namespace Track\Application\Query;

use Common\Application\QueryBuilder\Port\QueryBuilder;
use Psr\Log\LoggerInterface;
use Track\Application\Query\Projection\HealthCheck;

class HealthCheckQueryHandler
{
    /**
     * @param LoggerInterface $logger
     * @param QueryBuilder $queryBuilder
     */
    public function __construct(private LoggerInterface $logger, QueryBuilder $queryBuilder)
    {
    }

    /**
     * @param HealthCheckQuery $query
     * @return HealthCheck
     */
    public function __invoke(HealthCheckQuery $query): HealthCheck
    {
        $this->logger->info('Query: Healthcheck OK', [
            $query->timestamp,
        ]);


        return new HealthCheck('ok');
    }
}