<?php

namespace Ride\Delivery\Http\Controller;

use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Ride\Application\Handlers\Command\JoinRideCommand;
use Ride\Application\Handlers\Command\RequestJoinRideCommand;
use Ride\Application\Handlers\Command\UpdateRideCommand;
use Ride\Application\Handlers\Query\FindRideByIdQuery;
use Ride\Delivery\Http\Request\Dto\UpdatedRideRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;


class RequestJoinRideController extends Controller
{
    /**
     * @param string $id
     * @return JsonResponse
     */
    #[Route('/join-ride/{id}', name: 'join-ride', methods: ['POST', 'GET'], format: 'json')]
    public function __invoke(
        string $id,
    )
    {
        $this->logger->info('Received request to join Ride');

        try {
            $this->commandBus->execute(new RequestJoinRideCommand(
                rideId: $id,
                riderId: $this->identity->getId()->toString(),
            ));
        } catch (\Throwable $e) {
            return new JsonResponse([
                'error' => $e->getMessage(),
            ], 403);
        }

        $this->logger->info('Request to join ride processed');

        return new JsonResponse([
            'ok' => 'updated',
        ]);
    }
}
