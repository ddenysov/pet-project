<?php

namespace Common\Application\Bus\Port;

use Common\Application\Handlers\Command\Port\Command;

interface CommandBus
{
    public function execute(Command $command): void;
}