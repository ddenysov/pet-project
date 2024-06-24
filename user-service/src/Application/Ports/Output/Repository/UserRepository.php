<?php

namespace User\Application\Ports\Output\Repository;

use User\Domain\Model\Entity\User;
use User\Domain\Model\ValueObject\UserId;

interface UserRepository
{
    /**
     * @param User $user
     * @return void
     */
    public function save(User $user): void;

    /**
     * @param UserId $id
     * @return User|null
     */
    public function find(UserId $id): ?User;
}