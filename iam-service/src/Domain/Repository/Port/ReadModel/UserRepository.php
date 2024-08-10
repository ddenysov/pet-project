<?php

namespace Iam\Domain\Repository\Port\ReadModel;

use Common\Domain\Repository\Port\Repository;
use Iam\Domain\Entity\User;
use Iam\Domain\ValueObject\UserEmail;

interface UserRepository extends Repository
{
    /**
     * @param UserEmail $email
     * @return bool
     */
    public function isEmailTaken(UserEmail $email): bool;

    /**
     * @param UserEmail $email
     * @return User
     */
    public function findOneByEmail(UserEmail $email): User;

    public function save();
}