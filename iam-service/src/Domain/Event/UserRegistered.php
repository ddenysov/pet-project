<?php

namespace Iam\Domain\Event;

use Iam\Domain\ValueObject\UserEmail;
use Iam\Domain\ValueObject\UserPassword;

class UserRegistered extends UserEvent
{
    /**
     * @param UserEmail $email
     * @param UserPassword $password
     */
    public function __construct(
        readonly public UserEmail $email,
        readonly public UserPassword $password
    )
    {
    }
}