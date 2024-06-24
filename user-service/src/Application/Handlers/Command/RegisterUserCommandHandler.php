<?php

namespace User\Application\Handlers\Command;

use User\Application\Dto\UserDto;
use User\Application\Handlers\Query\FindUserQuery;
use User\Application\Ports\Output\Repository\UserRepository;
use User\Domain\Model\Entity\User;
use User\Domain\Model\ValueObject\UserId;
use User\Domain\Model\ValueObject\UserName;
use User\Domain\Model\ValueObject\UUID;

class RegisterUserCommandHandler
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
    public function handle(RegisterUserCommand $command): void
    {
        $user = new User(
            id: new UserId(UUID::generate()->toString()),
            name: new UserName($command->name),
        );

        $events = $user->releaseEvents();
        $this->repository->save($user);
    }
}