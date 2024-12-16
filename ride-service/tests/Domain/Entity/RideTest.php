<?php
declare(strict_types=1);

namespace Domain\Entity;

use Common\Domain\ValueObject\DateTimeValue;
use Common\Domain\ValueObject\GeoLocationValue;
use Common\Domain\ValueObject\ImageValue;
use Common\Domain\ValueObject\Uuid;
use PHPUnit\Framework\TestCase;
use Ride\Domain\Entity\Ride;
use Ride\Domain\ValueObject\OrganizerId;
use Ride\Domain\ValueObject\RideDescription;
use Ride\Domain\ValueObject\RideName;
use Ride\Domain\ValueObject\RideRules;
use Tests\Domain\Entity\Stub\StubEntity;
use Tests\Domain\Entity\Stub\StubId;
use Tests\Domain\Entity\Stub\StubString;

final class RideTest extends TestCase
{
    public function testCase1(): void
    {
        $ride = Ride::create(
            organizerId: new OrganizerId(Uuid::create()->toString()),
            name: new RideName('Test Name'),
            description: new RideDescription('test description'),
            rules: new RideRules('test rules'),
            dateTimeStart: new DateTimeValue('2024-01-01 00:00:00'),
            dateTimeEnd: new DateTimeValue('2024-01-01 00:00:00'),
            image: ImageValue::fromUrl('/images.jpg'),
            locationStart: GeoLocationValue::fromArray([10,20]),
            locationFinish: GeoLocationValue::fromArray([10,20]),
        );

        $events = $ride->releaseEvents();

        $this->assertTrue(count($events) === 1);
    }
}