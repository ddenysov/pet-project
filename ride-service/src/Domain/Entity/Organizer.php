<?php

namespace Ride\Domain\Entity;

use Common\Domain\Entity\Aggregate;
use Common\Domain\ValueObject\StringValue;
use Ride\Domain\ValueObject\OrganizerId;

class Organizer extends Aggregate implements \Common\Domain\Entity\Port\Aggregate
{
    /**
     * @var StringValue
     */
    private StringValue $name;

    public function getId(): OrganizerId
    {
        return OrganizerId::fromUuid($this->id);
    }
}