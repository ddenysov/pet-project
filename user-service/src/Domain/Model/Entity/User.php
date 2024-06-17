<?php

namespace User\Domain\Model\Entity;

use User\Domain\Model\ValueObject\UserId;
use Attribute;

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

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id->toString(),
        ];
    }
}