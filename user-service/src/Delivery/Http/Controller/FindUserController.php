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

    #[Route('/user/{id}')]
    public function index(string $id): JsonResponse
    {
        $user = $this->queryBus->execute(new FindUserQuery(id: $id));

        return new UserResponse($user);
    }
}
