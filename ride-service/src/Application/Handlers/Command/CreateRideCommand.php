<?php

namespace Ride\Application\Handlers\Command;

use Common\Application\Handlers\Command\Command;
use Common\Domain\ValueObject\StringValue;

class CreateRideCommand extends Command
{
    public function __construct(public string $name)
    {
    }
}