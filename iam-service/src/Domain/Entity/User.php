<?php

namespace Iam\Domain\Entity;

use Common\Domain\Entity\Entity;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Iam\Domain\ValueObject\UserId;
use Iam\Domain\ValueObject\UserName;

final class User extends Entity
{
    /**
     * @return UserId
     * @throws InvalidUuidException
     */
    public function getId(): UserId
    {
        return UserId::fromUuid($this->id);
    }
}