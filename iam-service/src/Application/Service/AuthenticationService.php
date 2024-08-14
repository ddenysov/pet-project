<?php

namespace Iam\Application\Service;

use Common\Application\Bus\Port\QueryBus;
use Common\Domain\ValueObject\Exception\String\InvalidStringLengthException;
use Common\Domain\ValueObject\PasswordValue;
use Iam\Application\Handlers\Query\FindUserByEmailQuery;

class AuthenticationService
{
    public function __construct(private readonly QueryBus $queryBus)
    {
    }

    /**
     * @param string $email
     * @param string $password
     * @return bool
     * @throws InvalidStringLengthException
     */
    public function checkCredentials(string $email, string $password): bool
    {
        $credentials = $this->queryBus->execute(new FindUserByEmailQuery($email));

        if (!$credentials) {
            return false;
        }

        return (new PasswordValue($credentials->password))->check($password);
    }
}