<?php

namespace User\Domain\Services;

use User\Domain\Model\Entity\User;
use User\Domain\Model\Event\UserRegistered;
use User\Domain\Model\ValueObject\UserName;

class RegisterUserService
{
    /**
     * @param UserName $name
     * @return User
     * @throws \Exception
     */
    public function execute(UserName $name): User
    {
        $user = User::create(name: $name);
        $user->record(new UserRegistered(
            name: $user->getName()
        ));

        return $user;
    }
}