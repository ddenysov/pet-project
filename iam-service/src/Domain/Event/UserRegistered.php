<?php

namespace Iam\Domain\Event;

use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Uuid;
use Iam\Domain\ValueObject\UserEmail;
use Iam\Domain\ValueObject\UserId;
use Iam\Domain\ValueObject\UserPassword;

class UserRegistered extends UserEvent
{
    /**
     * @param UserId $aggregateId
     * @param UserEmail $email
     * @param UserPassword $password
     * @throws InvalidUuidException
     */
    public function __construct(
        UserId $aggregateId,
        readonly public UserEmail $email,
        readonly public UserPassword $password
    )
    {
        $this->aggregateId = $aggregateId;
        parent::__construct();
    }
}