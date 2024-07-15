<?php

namespace Iam\Application\Handlers\Command;


use Common\Application\Handlers\Command\Command;

class RegisterCommand extends Command
{
    public function __construct(
        public string $email,
        public string $password,
    ) {
    }
}