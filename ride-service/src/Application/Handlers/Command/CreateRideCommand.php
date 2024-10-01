<?php

namespace Ride\Application\Handlers\Command;

use Common\Application\Handlers\Command\Command;
use DateTimeInterface;

class CreateRideCommand extends Command
{
    public function __construct(
        public string            $organizerId,
        public string            $name,
        public string            $description,
        public DateTimeInterface $dateTimeStart,
        public DateTimeInterface $dateTimeEnd,
        public string            $image,
        public array             $locationStart,
        public array             $locationFinish,
    )
    {
    }
}