<?php

namespace Ride\Application\Handlers\Query;

use Common\Application\Handlers\Query\Port\Query;

class RideDataTableQuery implements Query
{
    public int $page = 1;

    public int $limit = 10;

    public string|null $field = null;

    public string $order = 'asc';

    public function __construct()
    {
    }
}