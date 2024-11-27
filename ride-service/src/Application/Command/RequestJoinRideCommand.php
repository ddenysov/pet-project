<?php

namespace Ride\Application\Command;

use Common\Application\Handlers\Command\Command;

class RequestJoinRideCommand extends Command
{
    public function __construct(
        public string $rideId,
        public string $riderId,
    ) {
    }
}