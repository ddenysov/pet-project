<?php

namespace User\Delivery\Http\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use User\Application\Handlers\Command\RegisterUserCommand;
use User\Application\Ports\Output\Bus\CommandBus;
use User\Delivery\Http\Response\CreatedResponse;

class RegisterUserController
{
    public function __construct(public CommandBus $commandBus)
    {
    }

    #[Route('/')]
    public function index(): JsonResponse
    {
        $this->commandBus->execute(new RegisterUserCommand(
            name: 'Some test user',
        ));

        return new CreatedResponse();
    }
}
