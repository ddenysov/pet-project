<?php

namespace User\Delivery\Http\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use User\Domain\Model\Entity\User;
use User\Domain\Model\ValueObject\UserId;
use User\Domain\Model\ValueObject\UserName;

class UserController
{
    #[Route('/')]
    public function index(): JsonResponse
    {
        $user = new User(
            id: UserId::generate(),
            name: new UserName('TestUser'),
        );

        return new JsonResponse($user->toArray());
    }
}