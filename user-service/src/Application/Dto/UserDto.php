<?php

namespace User\Application\Dto;

class UserDto implements Dto
{
    public string $id;

    public string $name;

    /**
     * @param string $id
     * @param string $name
     */
    public function __construct(string $id, string $name)
    {
        $this->id   = $id;
        $this->name = $name;
    }
}