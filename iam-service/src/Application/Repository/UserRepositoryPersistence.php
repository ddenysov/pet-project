<?php

namespace Iam\Application\Repository;

use Common\Application\Repository\PersistenceRepository;
use Iam\Domain\Entity\User;
use Iam\Domain\Repository\Port\UserRepositoryPersistence as UserRepositoryPersistencePort;
use Iam\Domain\ValueObject\UserId;
use Iam\Infrastructure\Persistence\Doctrine\Entity\EventStore;

class UserRepositoryPersistence extends PersistenceRepository implements UserRepositoryPersistencePort
{
    public function find(UserId $id): User
    {
        $events = $this->eventStore->getEventStream($id, EventStore::class);

        return User::restore($events);
    }

    public function save(User $user): void
    {
        $events = $user->releaseEvents();

        foreach ($events as $event) {
            $this->eventStore->append($event);
        }
    }
}