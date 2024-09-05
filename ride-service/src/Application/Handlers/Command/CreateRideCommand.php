<?php

namespace Ride\Application\Handlers\Command;

use Common\Application\Handlers\Command\Command;

class CreateRideCommand extends Command
{
    public function __construct(
        public string $organizerId,
        public string $name
    ) {
    }
}