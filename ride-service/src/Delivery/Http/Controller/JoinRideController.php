<?php

namespace Ride\Delivery\Http\Controller;

use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Ride\Application\Handlers\Command\JoinRideCommand;
use Ride\Application\Handlers\Command\UpdateRideCommand;
use Ride\Application\Handlers\Query\FindRideByIdQuery;
use Ride\Delivery\Http\Request\Dto\UpdatedRideRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;


class JoinRideController extends Controller
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
        $this->logger->info('Ride join started');

        try {
            $this->commandBus->execute(new JoinRideCommand(
                rideId: $id,
                riderId: $this->identity->getId()->toString(),
            ));
        } catch (\Throwable $e) {
            return new JsonResponse([
                'error' => $e->getMessage(),
            ], 403);
        }

        $this->logger->info('Ride join finished');

        return new JsonResponse([
            'ok' => 'updated',
        ]);
    }
}
