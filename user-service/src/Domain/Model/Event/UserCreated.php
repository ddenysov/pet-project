<?php

namespace User\Domain\Model\Event;

use User\Domain\Model\ValueObject\UserId;
use User\Domain\Model\ValueObject\UserName;

readonly final class UserCreated extends UserEvent
{
    public function getName(): string
    {
        return 'user.created';
    }
}