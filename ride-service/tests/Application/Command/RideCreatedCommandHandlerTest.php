<?php
declare(strict_types=1);

namespace Application\Command;

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

final class RideCreatedCommandHandlerTest extends TestCase
{
    public function testCase1(): void
    {
        $this->assertTrue(true);
    }
}