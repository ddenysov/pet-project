<?php

namespace User\Application\Ports\Output\Bus;

interface QueryBus
{
    public function execute(mixed $query): mixed;
}