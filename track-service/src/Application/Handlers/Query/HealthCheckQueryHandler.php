<?php

namespace Track\Application\Handlers\Query;

use Psr\Log\LoggerInterface;
use Track\Application\Handlers\Query\Projection\HealthCheck;

class HealthCheckQueryHandler
{
    /**
     * @param LoggerInterface $logger
     */
    public function __construct(private LoggerInterface $logger)
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