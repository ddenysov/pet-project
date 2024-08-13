<?php

namespace Iam\Application\Handlers\Query\Projection;

class UserCredentials
{
    /**
     * @var string
     */
    public string $id;

    /**
     * @var string
     */
    public string $email;

    /**
     * @var string
     */
    public string $password;

    /**
     * @param string $id
     * @param string $email
     * @param string $password
     */
    public function __construct(string $id, string $email, string $password)
    {
        $this->id       = $id;
        $this->email    = $email;
        $this->password = $password;
    }


}