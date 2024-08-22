<?php

namespace Ride\Application\Handlers\Query\Projection;

class HealthCheck
{
    public string $status;

    /**
     * @param string $status
     */
    public function __construct(string $status)
    {
        $this->status = $status;
    }
}