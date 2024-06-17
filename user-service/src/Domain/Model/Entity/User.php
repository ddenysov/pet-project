<?php

namespace User\Domain\Model\Entity;

use User\Domain\Model\ValueObject\UserId;
use User\Domain\Model\ValueObject\UserName;

class User
{
    /**
     * @param UserId $id
     * @param UserName $name
     */
    public function __construct(
        private readonly UserId   $id,
        private UserName $name,
    )
    {

    }

    public function getId(): UserId
    {
        return $this->id;
    }

    /**
     * @return UserName
     */
    public function getName(): UserName
    {
        return $this->name;
    }

    /**
     * @param UserName $name
     * @return void
     */
    public function setName(UserName $name): void
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id'   => $this->id->toString(),
            'name' => $this->name->toString(),
        ];
    }
}