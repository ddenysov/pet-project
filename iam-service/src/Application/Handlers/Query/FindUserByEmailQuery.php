<?php

namespace Iam\Application\Handlers\Query;

use Common\Application\Handlers\Query\Port\Query;

class FindUserByEmailQuery implements Query
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