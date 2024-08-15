<?php

namespace Iam\Application\Service;

use Common\Application\Auth\Port\TokenEncoder;
use Common\Application\Bus\Port\QueryBus;
use Common\Domain\ValueObject\Exception\String\InvalidStringLengthException;
use Common\Domain\ValueObject\PasswordValue;
use Iam\Application\Handlers\Query\FindUserByEmailQuery;
use Iam\Application\Handlers\Query\Projection\UserCredentials;

class AuthenticationService
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly TokenEncoder $tokenEncoder
    ) {
    }

    /**
     * @param string $email
     * @param string $password
     * @return UserCredentials|null
     * @throws InvalidStringLengthException
     */
    public function checkCredentials(string $email, string $password): ?UserCredentials
    {

        $credentials = $this->queryBus->execute(new FindUserByEmailQuery($email));


        if (!$credentials) {
            return null;
        }

        if (!(new PasswordValue($credentials->password))->check($password)) {
            return null;
        }

        return $credentials;
    }

    /**
     * @param UserCredentials $credentials
     * @return string
     */
    public function createToken(UserCredentials $credentials): string
    {
        return $this->tokenEncoder->execute([
            'id'    => $credentials->id,
            'email' => $credentials->email,
        ], 'ololo');
    }
}