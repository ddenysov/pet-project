<?php

namespace Iam\Delivery\Http\Controller\Private;

use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Iam\Application\Handlers\Query\FindUserByEmailQuery;
use Iam\Application\Handlers\Query\Projection\UserCredentials;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GetUserController extends Controller
{

    #[Route('/private/user/{id}', name: 'private_get_user', methods: ['GET'], format: 'json')]
    public function __invoke(string $id): JsonResponse
    {
        dd($id);
        $credentials = $this->queryBus->execute(new FindUserByEmailQuery($checkEmail->email));

        return $this->successResponse($credentials);
    }

    /**
     * @param UserCredentials|null $credentials
     * @return JsonResponse
     */
    private function successResponse(?UserCredentials $credentials = null): JsonResponse
    {
        return new JsonResponse([
            'exists' => !!$credentials,
        ]);
    }
}
