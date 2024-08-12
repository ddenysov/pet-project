<?php

namespace Iam\Application\Handlers\Query\Port;

use Iam\Application\Handlers\Query\FindUserByEmailQuery;
use Iam\Application\Handlers\Query\ReadModel\UserCredentials;

interface FindUserByEmailQueryHandler
{
    /**
     * @param FindUserByEmailQuery $query
     * @return UserCredentials
     */
    public function handle(FindUserByEmailQuery $query): ?UserCredentials;
}