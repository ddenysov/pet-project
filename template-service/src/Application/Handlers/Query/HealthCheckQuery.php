<?php

namespace Template\Application\Handlers\Query;

use Common\Application\Handlers\Query\Port\Query;

class HealthCheckQuery implements Query
{
    public int $timestamp;

    /**
     * @param int $timestamp
     */
    public function __construct(int $timestamp)
    {
        $this->timestamp = $timestamp;
    }


}