<?php

namespace Iam\Domain\Repository\Port;

use Iam\Domain\Entity\User;

interface UserRepository
{
    public function save(User $user): void;
}