<?php

namespace Common\Components\DataTable\Query;

use Common\Application\Handlers\Query\Port\Query;

class DataTableQuery implements Query
{
    public int $start = 1;

    public int $length = 10;
}