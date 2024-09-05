<?php

namespace Tests\Domain;

use Common\Domain\ValueObject\Exception\InvalidUuidException;
use PHPUnit\Framework\TestCase;
use Ride\Domain\Entity\Ride;
use Ride\Domain\ValueObject\OrganizerId;

class OrganizerCanCreateRide extends TestCase
{
    /**
     * @throws InvalidUuidException
     */
    public function testCanCreateRide()
    {
        $organizerId = OrganizerId::create();
        $ride = Ride::organize(
            organizerId: $organizerId,
            name: new RideName('New ride'),
        );

        $events = $ride->releaseEvents();

        $this->assertInstanceOf(Ride::class, $ride);
    }
}
