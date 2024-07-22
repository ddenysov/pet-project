<?php

namespace Iam\Domain\Event;

use Common\Domain\Event\Port\Event;
use Common\Domain\ValueObject\Uuid;
use Iam\Domain\ValueObject\UserId;

abstract class UserEvent  implements Event
{
    protected UserId $userId;

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function setUserId(UserId $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return UserId
     */
    public function getId()
    {
        return $this->userId;
    }

    /**
     * @param Uuid $id
     * @return void
     * @throws \Common\Domain\ValueObject\Exception\InvalidUuidException
     */
    public function setId(Uuid $id)
    {
        $this->userId = UserId::fromUuid($id);
    }
}