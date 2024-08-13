<?php

namespace Iam\Application\Handlers\Query;

use Iam\Application\Handlers\Query\Projection\UserCredentials;
use Iam\Application\Handlers\Query\Repository\Port\UserCredentialsRepository;

class FindUserByEmailQueryHandler
{
    /**
     * @param UserCredentialsRepository $repository
     */
    public function __construct(private UserCredentialsRepository $repository)
    {
    }

    /**
     * @param FindUserByEmailQuery $query
     * @return UserCredentials|null
     */
    public function __invoke(FindUserByEmailQuery $query): ?UserCredentials
    {
        return $this->repository->findByEmail($query->email);
    }
}