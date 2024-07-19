<?php

namespace Iam\Domain\Repository\Port\WriteModel;

use Common\Domain\Repository\Port\Repository;
use Iam\Domain\Entity\User;
use Iam\Domain\ValueObject\UserEmail;

interface UserRepository extends Repository
{
    /**
     * @param User $user
     * @return void
     */
    public function save(User $user): void;
}