<?php

namespace Ride\Application\Query\Organizer;

class OrganizerByIdQuery
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