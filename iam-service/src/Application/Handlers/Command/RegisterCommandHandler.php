<?php

namespace Iam\Application\Handlers\Command;

readonly class RegisterCommandHandler
{
    public function __construct()
    {

    }

    /**
     * @throws \Exception
     */
    public function handle(RegisterCommand $command): void
    {
        dd($command);
    }
}