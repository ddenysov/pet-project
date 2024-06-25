<?php

namespace User\Domain\Model\Event;

use User\Domain\Model\ValueObject\UserId;
use User\Domain\Model\ValueObject\UserName;

abstract readonly class UserEvent implements DomainEvent
{
    /**
     * @param UserId $id
     * @param UserName $name
     */
    public function __construct(
        private readonly UserId $id,
        private readonly UserName $name,
    ) {
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id->toString(),
            'name' => $this->name->toString(),
        ];
    }
}