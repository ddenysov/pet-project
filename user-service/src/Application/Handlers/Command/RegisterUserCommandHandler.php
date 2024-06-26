<?php

namespace User\Application\Handlers\Command;

use User\Application\Ports\Output\Repository\UserRepository;
use User\Application\Repository\OutboxRepository;
use User\Domain\Model\ValueObject\UserName;
use User\Domain\Services\RegisterUserService;

readonly class RegisterUserCommandHandler
{

    /**
     * @param UserRepository $repository
     * @param OutboxRepository $outboxRepository
     * @param RegisterUserService $registerUserService
     */
    public function __construct(
        private UserRepository      $repository,
        private OutboxRepository    $outboxRepository,
        private RegisterUserService $registerUserService
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
            $this->outboxRepository->save($event);
        }
        $this->repository->save($user);
    }
}