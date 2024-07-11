<?php

namespace Tests\Domain\Entity\Stub;

use Common\Domain\Entity\Entity;
use Common\Domain\ValueObject\Uuid;

class StubEntity extends Entity
{
    public function __construct(private StubId $id)
    {

    }

    public function toArray(): array
    {

    }

    public function getId(): StubId
    {
        return $this->id;
    }
}