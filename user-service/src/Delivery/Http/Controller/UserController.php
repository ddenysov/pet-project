<?php

namespace User\Delivery\Http\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController
{
    #[Route('/')]
    public function index(): Response
    {
        die('ololo');
    }
}