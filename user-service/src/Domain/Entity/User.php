<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\UserId;

class User
{
    /**
     * @param UserId $id
     */
    public function __construct(
        private readonly UserId $id,
    ) {

    }

    public function getId(): UserId
    {
        return $this->id;
    }
}