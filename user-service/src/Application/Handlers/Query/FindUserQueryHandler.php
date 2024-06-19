<?php

namespace User\Application\Handlers\Query;

use User\Application\Dto\UserDto;
use User\Domain\Model\ValueObject\UUID;

class FindUserQueryHandler
{
    public function handle(FindUserQuery $query): UserDto
    {
        return new UserDto(
            id: UUID::generate()->toString(),
            name: 'lalala',
        );
    }
}