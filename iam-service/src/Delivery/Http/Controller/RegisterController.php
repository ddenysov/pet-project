<?php

namespace Iam\Delivery\Http\Controller;

use Common\Application\Bus\Port\CommandBus;
use Iam\Delivery\Http\Request\Dto\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;

class RegisterController
{
    /**
     * @param CommandBus $commandBus
     */
    public function __construct(public CommandBus $commandBus)
    {
    }

    /**
     * @param Request $request
     * @return void
     */
    #[Route('/register', name: 'register', methods: ['POST', 'GET'], format: 'json')]
    public function index(
        #[MapQueryString] User $user
    )
    {
        dd($user);
    }
}
