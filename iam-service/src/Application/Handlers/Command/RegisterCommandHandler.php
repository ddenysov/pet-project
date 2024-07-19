<?php

namespace Iam\Application\Handlers\Command;

use Common\Application\Container\Port\ServiceContainer;
use Common\Application\Handlers\Command\Attributes\Transaction;
use Common\Application\Handlers\Command\CommandHandler;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Exception\String\InvalidStringLengthException;
use Iam\Domain\Entity\User;
use Iam\Domain\Repository\Port\ReadModel\UserRepository as ReadUserRepository;
use Iam\Domain\Repository\Port\WriteModel\UserRepository as WriteUserRepository;
use Iam\Domain\ValueObject\UserEmail;
use Iam\Domain\ValueObject\UserPassword;

final class RegisterCommandHandler extends CommandHandler
{
    /**
     * @param ServiceContainer $container
     * @param ReadUserRepository $readUserRepository
     * @param WriteUserRepository $writeUserRepository
     */
    public function __construct(
        ServiceContainer           $container,
        private ReadUserRepository $readUserRepository,
        private WriteUserRepository $writeUserRepository,
    ) {
        parent::__construct($container);
    }

    /**
     * @param RegisterCommand $command
     * @throws InvalidStringLengthException
     * @throws InvalidUuidException
     */
    #[Transaction]
    protected function handle(RegisterCommand $command): void
    {
        $emailRegistered = $this->readUserRepository->isEmailTaken(new UserEmail($command->email));
        if ($emailRegistered) {
            $user = $this->readUserRepository->findOneByEmail(new UserEmail($command->email));
            $user->requestResetPassword();
        } else {
            $user = User::register(
                email: new UserEmail($command->email),
                password: new UserPassword($command->password)
            );
            $this->writeUserRepository->save($user);
        }

        $this->publishAggregateEvents($user);
    }
}