<?php

namespace Iam\Application\Handlers\Command;

use Exception;
use Iam\Domain\Entity\User;
use Iam\Domain\Repository\Port\UserRepository;
use Iam\Domain\ValueObject\UserEmail;
use Iam\Domain\ValueObject\UserId;
use Iam\Domain\ValueObject\UserPassword;

readonly class RegisterCommandHandler
{
    public function __construct(private UserRepository $userRepository)
    {

    }

    /**
     * @throws Exception
     */
    public function handle(RegisterCommand $command): void
    {
        $user = new User(
            id: UserId::create(),
            email: new UserEmail($command->email),
            password: new UserPassword($command->password)
        );

        $this->userRepository->save($user);
    }
}