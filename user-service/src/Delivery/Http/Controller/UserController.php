<?php

namespace User\Delivery\Http\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use User\Domain\Model\Entity\User;
use User\Domain\Model\ValueObject\UserId;

class UserController
{
    #[Route('/')]
    public function index(): JsonResponse
    {
        $user = new User(
            id: UserId::generate(),
        );

        return new JsonResponse($user->toArray());
    }
}