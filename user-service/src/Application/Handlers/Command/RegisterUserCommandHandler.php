<?php

namespace User\Application\Handlers\Command;

use User\Application\Dto\UserDto;
use User\Application\Handlers\Query\FindUserQuery;
use User\Application\Ports\Output\Bus\EventBus;
use User\Application\Ports\Output\Repository\UserRepository;
use User\Domain\Model\Entity\User;
use User\Domain\Model\ValueObject\UserId;
use User\Domain\Model\ValueObject\UserName;
use User\Domain\Model\ValueObject\UUID;
use User\Domain\Services\RegisterUserService;

class RegisterUserCommandHandler
{

    /**
     * @param UserRepository $repository
     */
    public function __construct(
        private readonly UserRepository $repository,
        private readonly EventBus $eventBus,
        private readonly RegisterUserService $registerUserService
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function handle(RegisterUserCommand $command): void
    {
        $user = $this->registerUserService->execute(
            name: new UserName($command->name)
        );

        $events = $user->releaseEvents();
        foreach ($events as $event) {
            $this->eventBus->execute($event);
        }
        $this->repository->save($user);
    }
}