<?php

namespace User\Infrastructure\Adapter\Persistence\Doctrine;

use User\Domain\Model\Entity\User;
use User\Domain\Model\ValueObject\UserId;

class UserRepository implements \User\Application\Ports\Output\Repository\UserRepository
{
    public function save(User $user): void
    {
        // TODO: Implement save() method.
    }

    public function find(UserId $id): ?User
    {
        // TODO: Implement find() method.
    }
}