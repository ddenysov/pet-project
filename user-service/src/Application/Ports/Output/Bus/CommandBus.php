<?php

namespace User\Application\Ports\Output\Bus;

use User\Application\Handlers\Command\Command;

interface CommandBus
{
    public function execute(Command $command): void;
}