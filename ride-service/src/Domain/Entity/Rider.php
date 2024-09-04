<?php

namespace Ride\Domain\Entity;

use Common\Domain\Entity\Aggregate;
use Common\Domain\ValueObject\StringValue;
use Ride\Domain\ValueObject\RiderId;

class Rider extends Aggregate implements \Common\Domain\Entity\Port\Aggregate
{
    /**
     * @var StringValue
     */
    private StringValue $name;

    public function getId(): RiderId
    {
        return RiderId::fromUuid($this->id);
    }
}