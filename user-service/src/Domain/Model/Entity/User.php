<?php

namespace App\Domain\Model\Entity;

use App\Domain\Model\ValueObject\UserId;

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