<?php

namespace User\Application\Ports\Output\Bus;

use User\Application\Dto\Dto;
use User\Application\Handlers\Query\Query;

interface QueryBus
{
    public function execute(Query $query): Dto;
}