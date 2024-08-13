<?php

namespace Iam\Application\Handlers\Query\Repository\Port;

use Iam\Application\Handlers\Query\Projection\UserCredentials;

interface UserCredentialsRepository
{
    /**
     * @param string $email
     * @return UserCredentials
     */
    public function findByEmail(string $email): ?UserCredentials;
}