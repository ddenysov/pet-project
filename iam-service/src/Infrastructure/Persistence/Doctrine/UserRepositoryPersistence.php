<?php

namespace Iam\Infrastructure\Persistence\Doctrine;

use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Iam\Domain\Entity\User;
use Iam\Domain\Repository\Port\UserRepositoryPersistence as UserRepositoryPersistencePort;
use Iam\Domain\ValueObject\UserId;

class UserRepositoryPersistence extends Repository implements UserRepositoryPersistencePort
{
    /**
     * @param User $user
     * @return void
     */
    public function save(User $user): void
    {
        $events = $user->releaseEvents();

        foreach ($events as $event) {
            $this->getEventStore()->append($event);
        }
    }

    /**
     * @throws InvalidUuidException
     */
    public function find(UserId $id): User
    {
        $events = $this->getEventStore()->getEventStream($id);

        return User::restore($events);
    }
}