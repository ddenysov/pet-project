<?php

namespace Iam\Domain\Repository\Port;

use Iam\Domain\Entity\User;
use Iam\Domain\ValueObject\UserId;

interface UserRepositoryPersistence
{
    /**
     * @param UserId $id
     * @return User
     */
    public function find(UserId $id): User;

    /**
     * @param User $user
     * @return void
     */
    public function save(User $user): void;
}