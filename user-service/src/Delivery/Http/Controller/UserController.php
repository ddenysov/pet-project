<?php

namespace User\Delivery\Http\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use User\Application\Handlers\Query\FindUserQuery;
use User\Application\Ports\Output\Bus\QueryBus;

class UserController
{
    public function __construct(public QueryBus $queryBus)
    {
    }

    #[Route('/')]
    public function index(): JsonResponse
    {
        $user = $this->queryBus->execute(new FindUserQuery());

        return new JsonResponse($user->toArray());
    }
}

class MyMessageHandler
{

}

class MyMessage
{

}