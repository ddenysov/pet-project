<?php

namespace Iam\Delivery\Http\Controller;

use Common\Application\Bus\Port\CommandBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
    #[Route('/register', name: 'register', methods: ['POST', 'GET'])]
    public function index(Request $request)
    {
        dd('ololo');
    }
}
