<?php

namespace Iam\Application\Handlers\Command;

use Common\Application\Bus\Port\QueryBus;
use Common\Application\Container\Port\ServiceContainer;
use Common\Application\Handlers\Command\Attributes\Transaction;
use Common\Application\Handlers\Command\CommandHandler;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Exception\String\InvalidStringLengthException;
use Iam\Application\Handlers\Query\FindUserByEmailQuery;
use Iam\Domain\Entity\User;
use Iam\Domain\Repository\Port\UserRepositoryPersistence;
use Iam\Domain\ValueObject\UserEmail;
use Iam\Domain\ValueObject\UserId;
use Iam\Domain\ValueObject\UserPassword;
use Psr\Log\LoggerInterface;

final class LoginCommandHandler extends CommandHandler
{

    public function __construct(
        private UserRepositoryPersistence $userRepositoryPersistence,
        private QueryBus $queryBus,
    )
    {
    }

    #[Transaction]
    protected function handle(LoginCommand $command): void
    {
        $userCredentials = $this->queryBus->execute(new FindUserByEmailQuery(email: $command->email));

        if ($userCredentials) {
            $user = $this->userRepositoryPersistence->find(UserId::fromString($userCredentials->id));
        }
    }
}