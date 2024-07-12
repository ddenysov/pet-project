<?php

namespace Iam\Application\Handlers\Command;

readonly class RegisterCommandHandler
{
    /**
     * @throws \Exception
     */
    public function handle(RegisterCommand $command): void
    {
        dd($command);
    }
}