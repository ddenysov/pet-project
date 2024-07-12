<?php

namespace Iam\Delivery\Http\Controller;

use Common\Application\Bus\Port\CommandBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController
{
    public function __construct(public CommandBus $commandBus)
    {
    }

    #[Route('/register', name: 'register', methods: ['POST', 'GET'])]
    public function index(Request $request)
    {
        dd('ololo');
    }
}
