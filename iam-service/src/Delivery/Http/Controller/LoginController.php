<?php

namespace Iam\Delivery\Http\Controller;

use Common\Application\Bus\Port\CommandBus;
use Common\Application\Bus\Port\QueryBus;
use Common\Domain\ValueObject\Exception\String\InvalidStringLengthException;
use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Iam\Application\Handlers\Query\Projection\UserCredentials;
use Iam\Application\Service\AuthenticationService;
use Iam\Delivery\Http\Request\Dto\SecurityCredentials;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends Controller
{
    public function __construct(
        CommandBus                             $commandBus,
        QueryBus                               $queryBus,
        private readonly AuthenticationService $authenticationService,
    )
    {
        parent::__construct($commandBus, $queryBus);
    }

    /**
     * @param SecurityCredentials $securityCredentials
     * @return JsonResponse
     * @throws InvalidStringLengthException
     */
    #[Route('/login', name: 'login', methods: ['POST', 'GET'], format: 'json')]
    public function __invoke(
        #[MapRequestPayload] SecurityCredentials $securityCredentials
    ): JsonResponse
    {
        $credentials = $this->authenticationService->checkCredentials(
            $securityCredentials->email,
            $securityCredentials->password,
        );

        if (!$credentials) {
            return $this->wrongPasswordResponse();
        }

        return $this->successResponse($credentials);
    }

    /**
     * @return JsonResponse
     */
    private function wrongPasswordResponse(): JsonResponse
    {
        return new JsonResponse([
            'code'   => 422,
            'errors' => [
                'password' => [
                    'message' => 'Incorrect password',
                    'key'     => 'password',
                ],
            ],
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param UserCredentials $credentials
     * @return JsonResponse
     */
    private function successResponse(UserCredentials $credentials): JsonResponse
    {
        return new JsonResponse([
            'token' => $this->authenticationService->createToken($credentials),
        ]);
    }
}
