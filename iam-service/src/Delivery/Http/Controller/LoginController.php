<?php

namespace Iam\Delivery\Http\Controller;

use Common\Application\Bus\Port\CommandBus;
use Common\Delivery\Http\Request\Dto\DtoToCommandTransformer;
use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Iam\Application\Handlers\Command\RegisterCommand;
use Iam\Delivery\Http\Request\Dto\User;
use Iam\Domain\Repository\Port\ReadModel\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends Controller
{
    /**
     * @param User $user
     * @return JsonResponse
     * @throws \ReflectionException
     */
    #[Route('/register', name: 'register', methods: ['POST', 'GET'], format: 'json')]
    public function __invoke(
        #[MapQueryString] User $user
    ): JsonResponse
    {
        $this->commandBus->execute(
            DtoToCommandTransformer::transform($user, RegisterCommand::class),
        );

        return new JsonResponse();
    }
}
