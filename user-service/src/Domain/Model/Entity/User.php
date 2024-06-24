<?php

namespace User\Domain\Model\Entity;

use User\Domain\Model\Aggregate\Aggregate;
use User\Domain\Model\Event\UserCreated;
use User\Domain\Model\ValueObject\UserId;
use User\Domain\Model\ValueObject\UserName;
use User\Domain\Model\ValueObject\UUID;

class User extends Aggregate
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

    /**
     * @param UserName $name
     * @return self
     * @throws \Exception
     */
    public static function create(UserName $name): self
    {
        $instance = new self(
            id: UserId::generate(),
            name: $name,
        );
        $instance->record(new UserCreated());

        return $instance;
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