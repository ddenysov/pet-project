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

final class RequestPasswordCommandHandler extends CommandHandler
{
    /**
     * @param ServiceContainer $container
     * @param LoggerInterface $logger
     * @param UserRepositoryPersistence $userRepositoryPersistence
     */
    public function __construct(
        ServiceContainer                           $container,
        LoggerInterface                            $logger,
        private readonly UserRepositoryPersistence $userRepositoryPersistence,
    )
    {
        parent::__construct($container, $logger);
    }

    /**
     * Start Transaction
     * Business logic
     * Save Aggregate to Event Store
     * Save event to outbox
     * Commit
     *
     * @param RequestPasswordCommand $command
     * @throws InvalidUuidException
     */
    protected function handle(RequestPasswordCommand $command): void
    {
        $user = $this->userRepositoryPersistence->find(UserId::fromString($command->id));
        $user->requestResetPassword();

        $this->userRepositoryPersistence->save($user);
    }
}