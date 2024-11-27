<?php

namespace Ride\Application\Query;

use Common\Application\Handlers\Query\Port\Query;

class FindRideByIdQuery implements Query
{
    /**
     * @var string
     */
    public string $id;

    /**
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }
}