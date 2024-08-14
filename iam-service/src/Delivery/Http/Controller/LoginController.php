<?php

namespace Iam\Delivery\Http\Controller;

use Common\Application\Bus\Port\CommandBus;
use Common\Application\Bus\Port\QueryBus;
use Common\Domain\ValueObject\Exception\String\InvalidStringLengthException;
use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Iam\Application\Handlers\Query\FindUserByEmailQuery;
use Iam\Application\Service\AuthenticationService;
use Iam\Delivery\Http\Request\Dto\SecurityCredentials;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends Controller
{
    public function __construct(
        CommandBus $commandBus,
        QueryBus $queryBus,
        private AuthenticationService $authenticationService
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
        #[MapQueryString] SecurityCredentials $securityCredentials
    ): JsonResponse
    {
        $isValid = $this->authenticationService->checkCredentials(
            $securityCredentials->email,
            $securityCredentials->password,
        );

        dd($isValid);

        return new JsonResponse();
    }
}
