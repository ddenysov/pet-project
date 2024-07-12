<?php

namespace Iam\Domain\Entity;

use Common\Domain\Entity\Aggregate;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Uuid;
use Iam\Domain\ValueObject\UserId;
use Iam\Domain\ValueObject\UserPassword;

final class User extends Aggregate
{
    private UserPassword $password;

    public function __construct(Uuid $id, UserPassword $password)
    {
        $this->password = $password;
        parent::__construct($id);
    }

    /**
     * @return UserId
     * @throws InvalidUuidException
     */
    public function getId(): UserId
    {
        return UserId::fromUuid($this->id);
    }

    /**
     * @return UserPassword
     */
    public function getPassword(): UserPassword
    {
        return $this->password;
    }

    /**
     * @param UserPassword $password
     * @return void
     */
    public function setPassword(UserPassword $password): void
    {
        $this->password = $password;
    }
}