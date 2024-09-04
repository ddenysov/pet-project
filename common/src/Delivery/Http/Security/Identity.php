<?php

namespace Common\Delivery\Http\Security;

use Common\Domain\ValueObject\Uuid;

class Identity
{
    /**
     * @var Uuid
     */
    public Uuid $id;

    /**
     * @var array
     */
    public array $roles = [];
}