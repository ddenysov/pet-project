<?php

namespace Iam\Application\Handlers\Command;


use Common\Application\Handlers\Command\Command;

class RequestPasswordCommand extends Command
{
    public function __construct(
        public string $id,
    ) {
    }
}