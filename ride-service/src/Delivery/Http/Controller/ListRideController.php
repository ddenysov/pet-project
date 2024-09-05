<?php

namespace Ride\Delivery\Http\Controller;

use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Ride\Application\Handlers\Command\CreateRideCommand;
use Ride\Application\Handlers\Query\RideDataTableQuery;
use Ride\Delivery\Http\Request\Dto\CreateRideRequest;
use Ride\Delivery\Http\Security\CanCreateRide;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;


class ListRideController extends Controller
{
    /**
     * @param CreateRideRequest $ride
     * @param Request $request
     * @return JsonResponse
     * @throws \ReflectionException
     */
    #[Route('/list-ride', name: 'list-ride', methods: ['POST', 'GET'], format: 'json')]
    public function __invoke(
        Request $request
    ) {
        return new JsonResponse($this->queryBus->execute(new RideDataTableQuery()));
    }
}
