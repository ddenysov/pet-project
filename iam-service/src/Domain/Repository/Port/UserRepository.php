<?php

namespace Iam\Domain\Repository\Port;

use Common\Domain\Repository\Port\Repository;
use Iam\Domain\Entity\User;

interface UserRepository
{
    public function save(User $user): void;
}