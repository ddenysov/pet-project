<?php

namespace Iam\Domain\Repository\Port;
use Iam\Domain\Entity\User;
use Iam\Domain\ValueObject\UserId;

interface UserRepository
{
    public function find(UserId $id): User;
}