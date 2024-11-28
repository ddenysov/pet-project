<?php

namespace Ride\Application\Command;

use Common\Application\Handlers\Command\Command;
use DateTimeInterface;

class CreateRideCommand extends Command
{
    public function __construct(
        public string            $organizerId,
        public string            $trackId,
        public string            $name,
        public string            $description,
        public string            $rules,
        public string            $equip,
        public string            $locationStartDescription,
        public DateTimeInterface $dateTimeStart,
        public DateTimeInterface $dateTimeEnd,
        public string            $image,
        public array             $locationStart,
        public array             $locationFinish,
        public string            $surface,
        public string            $bikeType,
        public string            $difficulty,
        public string            $access,
        public string            $registrationType,
        public string            $status,
    )
    {
    }
}