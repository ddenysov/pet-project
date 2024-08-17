<?php

namespace Iam\Delivery\Http\Controller;

use Common\Application\Bus\Port\CommandBus;
use Common\Delivery\Http\Request\Dto\DtoToCommandTransformer;
use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Iam\Application\Handlers\Command\RegisterCommand;
use Iam\Application\Handlers\Command\RequestPasswordCommand;
use Iam\Application\Handlers\Query\FindUserByEmailQuery;
use Iam\Delivery\Http\Request\Dto\User;
use Iam\Domain\Repository\Port\ReadModel\UserRepository;
use ReflectionException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends Controller
{
    /**
     * @param User $user
     * @return JsonResponse
     * @throws ReflectionException
     */
    #[Route('/register', name: 'register', methods: ['POST', 'GET'], format: 'json')]
    public function __invoke(
        #[MapRequestPayload] User $user
    ): JsonResponse {
        $userCredentials = $this->queryBus->execute(new FindUserByEmailQuery(email: $user->email));

        if ($userCredentials) {
            $this->commandBus->execute(
                new RequestPasswordCommand($userCredentials->id),
            );
        } else {
            $this->commandBus->execute(
                DtoToCommandTransformer::transform($user, RegisterCommand::class),
            );
        }

        return new JsonResponse();
    }
}
