<?php

namespace Common\Application\Bus\Port;

use Common\Application\Handlers\Query\Port\Query;

interface QueryBus
{
    public function execute(Query $query);
}