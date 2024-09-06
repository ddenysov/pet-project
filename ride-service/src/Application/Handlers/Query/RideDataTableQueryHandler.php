<?php

namespace Ride\Application\Handlers\Query;

use Psr\Log\LoggerInterface;
use Ride\Application\Handlers\Query\Projection\HealthCheck;

class RideDataTableQueryHandler
{
    /**
     * @param LoggerInterface $logger
     * @param RideView $view
     */
    public function __construct(private LoggerInterface $logger, RideView $view)
    {
    }

    public function __invoke(RideDataTableQuery $query)
    {
        return [
            'ololo'
        ];
    }
}