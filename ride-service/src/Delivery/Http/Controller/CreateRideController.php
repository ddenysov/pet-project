<?php

namespace Ride\Delivery\Http\Controller;

use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Ride\Application\Handlers\Command\CreateRideCommand;
use Ride\Delivery\Http\Request\Dto\CreateRideRequest;
use Ride\Delivery\Http\Request\Dto\NewRideInfo;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Ride\Application\Handlers\Command\HealthCheckCommand;
use Ride\Application\Handlers\Query\HealthCheckQuery;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;


class CreateRideController extends Controller
{
    /**
     * @param CreateRideRequest $ride
     * @param Request $request
     * @return JsonResponse
     * @throws \ReflectionException
     */
    #[Route('/create-ride', name: 'create-ride', methods: ['POST', 'GET'], format: 'json')]
    public function __invoke(
        #[MapQueryString] CreateRideRequest $ride,
        Request $request
    )
    {
        $this->logger->info('Ride created');
        $this->commandBus->execute($ride->transform(CreateRideCommand::class));

        return new JsonResponse([
            'ok' => 'created',
        ]);
    }
}
