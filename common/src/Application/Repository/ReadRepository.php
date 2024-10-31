<?php

namespace Common\Application\Repository;

use Common\Domain\ValueObject\Uuid;

abstract class ReadRepository
{
    public function findById(Uuid $id): mixed
    {

    }
}