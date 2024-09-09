<?php

namespace Ride\Application\Handlers\Query;

class FindRideByIdQuery
{
    /**
     * @var string
     */
    public string $id;

    /**
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }
}