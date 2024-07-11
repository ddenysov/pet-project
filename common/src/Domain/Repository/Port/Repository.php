<?php

namespace Common\Domain\Repository\Port;

use Common\Domain\ValueObject\Uuid;

interface Repository
{
    public function find($id);
}