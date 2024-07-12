<?php

namespace User\Application\Ports\Output\Bus;

use Common\Application\Handlers\Query\Port\Query;
use User\Application\Dto\Dto;

interface QueryBus
{
    public function execute(Query $query): Dto;
}