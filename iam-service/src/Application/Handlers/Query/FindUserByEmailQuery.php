<?php

namespace Iam\Application\Handlers\Query;

class FindUserByEmailQuery
{
    public string $email;

    /**
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }


}