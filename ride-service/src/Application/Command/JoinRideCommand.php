<?php

namespace Ride\Application\Command;

use Common\Application\Handlers\Command\Command;

class JoinRideCommand extends Command
{
    public function __construct(
        public string $rideId,
        public string $riderId,
    ) {
    }
}