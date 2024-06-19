<?php

namespace User\Application\Ports\Output\Repository;

use User\Domain\Model\Entity\User;
use User\Domain\Model\ValueObject\UserId;

interface UserRepository
{
    public function save(User $user): void;

    public function find(UserId $id): ?User;
}