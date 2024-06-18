<?php

namespace User\Application\Handlers\Query;

use User\Domain\Model\Entity\User;
use User\Domain\Model\ValueObject\UserId;
use User\Domain\Model\ValueObject\UserName;

class FindUserQueryHandler
{
    public function handle(FindUserQuery $query)
    {
        return new User(
            id: UserId::generate(),
            name: new UserName('TestUser'),
        );
    }
}