<?php

namespace Ride\Application\Handlers\Command;

use Common\Application\Handlers\Command\Command;

class UpdateRideCommand extends Command
{
    public function __construct(
        public string $id,
        public string $organizerId,
        public string $name,
    ) {
    }
}