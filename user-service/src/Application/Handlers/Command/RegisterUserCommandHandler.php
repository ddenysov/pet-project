<?php

namespace User\Application\Handlers\Command;

use User\Application\Outbox\Outbox;
use User\Application\Outbox\OutboxRepository;
use User\Application\Outbox\OutboxStatus;
use User\Application\Ports\Output\Repository\UserRepository;
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
            $this->outboxRepository->save(new Outbox(
                id: $event->getEventId()->toUuid(),
                name: $event->getName(),
                payload: $event->toArray(),
                status: OutboxStatus::STARTED,
                createdAt: $event->getCreatedAt()->toDateTime()
            ));
        }
        $this->repository->save($user);
    }
}