<?php

namespace Iam\Delivery\Http\Controller\Public;

use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Iam\Application\Handlers\Query\FindUserByEmailQuery;
use Iam\Application\Handlers\Query\Projection\UserCredentials;
use Iam\Delivery\Http\Request\Dto\CheckEmail;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class CheckEmailController extends Controller
{
    /**
     * @param CheckEmail $checkEmail
     * @return JsonResponse
     */
    #[Route('/check-email', name: 'check_email', methods: ['POST', 'GET'], format: 'json')]
    public function __invoke(
        #[MapRequestPayload] CheckEmail $checkEmail
    ): JsonResponse
    {
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
