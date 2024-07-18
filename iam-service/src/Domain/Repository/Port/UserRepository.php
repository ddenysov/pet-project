<?php

namespace Iam\Domain\Repository\Port;

use Common\Domain\Entity\Entity;
use Common\Domain\Repository\Port\Repository;
use Common\Domain\ValueObject\ValueObject;
use Iam\Domain\Entity\User;
use Iam\Domain\ValueObject\UserEmail;

interface UserRepository extends Repository
{
    /**
     * @param User $user
     * @return void
     */
    public function save(User $user): void;

    /**
     * @param UserEmail $email
     * @return User
     */
    public function findOneByEmail(UserEmail $email): ?User;
}