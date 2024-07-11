<?php

namespace Tests\Domain\Entity\Stub;

use Common\Domain\Entity\Entity;
use Common\Domain\ValueObject\Uuid;

class StubEntity extends Entity
{
    public function __construct(
        private StubId $id,
        private StubString $name
    ) {
    }

    public function getId(): StubId
    {
        return $this->id;
    }

    public function getName(): StubString
    {
        return $this->name;
    }

    protected function serialize(): array
    {
        return [
            'name' => $this->name->toString(),
        ];
    }
}