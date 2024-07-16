<?php

namespace Iam\Domain\Repository\Port;

use Common\Domain\Repository\Port\Repository;
use Iam\Domain\Entity\User;

interface UserRepository extends Repository
{
    /**
     * @param User $user
     * @return void
     */
    public function save(User $user): void;
}