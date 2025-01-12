<?php

namespace Tests\Mock\Domain\Entity;

use Common\Domain\Entity\Entity;

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