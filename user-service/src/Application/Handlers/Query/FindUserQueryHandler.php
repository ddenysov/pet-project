<?php

namespace User\Application\Handlers\Query;

use User\Application\Dto\UserDto;
use User\Application\Ports\Output\Repository\UserRepository;
use User\Domain\Model\ValueObject\UserId;
use User\Domain\Model\ValueObject\UUID;

class FindUserQueryHandler
{

    /**
     * @param UserRepository $repository
     */
    public function __construct(private readonly UserRepository $repository)
    {
    }

    /**
     * @throws \Exception
     */
    public function handle(FindUserQuery $query): UserDto
    {
        $user = $this->repository->find(new UserId($query->id));

        return new UserDto(
            id: $user->getId()->toString(),
            name: $user->getName()->toString(),
        );
    }
}