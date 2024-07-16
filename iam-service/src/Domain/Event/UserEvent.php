<?php

namespace Iam\Domain\Event;

use Common\Domain\Event\Port\Event;
use Iam\Domain\Entity\User;

abstract class UserEvent  implements Event
{

    public function __construct(private readonly User $user)
    {
    }

    public function getUser(): User
    {
        return $this->user;
    }
}