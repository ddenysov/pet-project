<?php

namespace User\Infrastructure\Adapter\Persistence\Memory;

use User\Domain\Model\Entity\User;
use User\Domain\Model\ValueObject\UserId;
use User\Domain\Model\ValueObject\UserName;
use User\Infrastructure\Adapter\Persistence\Memory\Data\UsersDataset;

class UserRepository implements \User\Application\Ports\Output\Repository\UserRepository
{
    public function save(User $user): void
    {
        UsersDataset::$data[] = $user->toArray();
    }

    /**
     * @throws \Exception
     */
    public function find(UserId $id): ?User
    {
        $users = UsersDataset::$data;

        foreach ($users as $item) {
            if ($item['id'] == $id->toString()) {
                return new User(
                    id: new UserId($item['id']),
                    name: new UserName($item['name'])
                );
            }
        }
        return null;
    }
}