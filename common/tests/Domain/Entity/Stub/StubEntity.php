<?php

namespace Tests\Domain\Entity\Stub;

use Common\Domain\Entity\Entity;
use Common\Domain\ValueObject\Uuid;

class StubEntity extends Entity
{
    /**
     * @var StubString
     */
    protected StubString $name;

    /**
     * @param StubId $id
     * @param StubString $name
     */
    public function __construct(StubId $id, StubString $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
    /**
     * @return StubString
     */
    public function getName(): StubString
    {
        return $this->name;
    }
}