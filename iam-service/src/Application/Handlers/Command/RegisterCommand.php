<?php

namespace Iam\Application\Handlers\Command;


use Common\Application\Handlers\Command\Command;

class RegisterCommand extends Command
{
    public string $name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }
}