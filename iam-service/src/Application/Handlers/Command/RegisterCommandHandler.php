<?php

namespace Iam\Application\Handlers\Command;

use Exception;
use Iam\Domain\Service\RegisterService;

readonly class RegisterCommandHandler
{
    public function __construct(private RegisterService $registerService)
    {
    }

    /**
     * @throws Exception
     */
    public function handle(RegisterCommand $command): void
    {
        $events = $this->registerService->execute(email: $command->email,password: $command->password);
    }
}