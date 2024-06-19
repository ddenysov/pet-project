<?php

namespace User\Delivery\Http\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use User\Application\Handlers\Query\FindUserQuery;
use User\Application\Ports\Output\Bus\QueryBus;
use User\Delivery\Http\Response\UserResponse;

class FindUserController
{
    public function __construct(public QueryBus $queryBus)
    {
    }

    #[Route('/')]
    public function index(): JsonResponse
    {
        $user = $this->queryBus->execute(new FindUserQuery(id: '0c0a1a41-3f25-4536-87f7-b6468c2901f7'));

        return new UserResponse($user);
    }
}
