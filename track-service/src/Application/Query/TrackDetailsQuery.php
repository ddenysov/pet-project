<?php

namespace Track\Application\Query;

use Common\Application\Handlers\Query\Port\Query;

class TrackDetailsQuery implements Query
{
    public function __construct(
        private ?string $id,
    ) {}

    public function getId(): ?string
    {
        return $this->id;
    }
}