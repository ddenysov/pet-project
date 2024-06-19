<?php

namespace User\Application\Handlers\Query;

class FindUserQuery implements Query
{
    public string $id;

    /**
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }
}