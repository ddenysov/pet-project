<?php

namespace Template\Application\Handlers\Query;

use Psr\Log\LoggerInterface;
use Template\Application\Handlers\Query\Projection\HealthCheck;

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
        $this->logger->info('Healthcheck query OK', [
            $query->timestamp,
        ]);


        return new HealthCheck('ok');
    }
}