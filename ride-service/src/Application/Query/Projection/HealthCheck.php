<?php

namespace Ride\Application\Query\Projection;

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