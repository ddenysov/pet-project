<?php

namespace Ride\Delivery\Http\Controller;

use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Ride\Application\Command\UpdateRideCommand;
use Ride\Application\Handlers\Query\FindRideByIdQuery;
use Ride\Delivery\Http\Request\Dto\UpdatedRideRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;


class UpdateRideController extends Controller
{
    /**
     * @param string $id
     * @param UpdatedRideRequest $request
     * @return JsonResponse
     * @throws \ReflectionException
     */
    #[Route('/update-ride/{id}', name: 'update-ride', methods: ['POST', 'GET'], format: 'json')]
    public function __invoke(
        string $id,
        #[MapRequestPayload] UpdatedRideRequest $request,
    )
    {
        $ride = $this->queryBus->execute(new FindRideByIdQuery($id));

        $this->logger->info('Ride update started');

        try {
            $this->commandBus->execute(new UpdateRideCommand(
                id: $id,
                organizerId: $this->identity->getId()->toString(),
                name: $request->name,
            ));
        } catch (\Throwable $e) {
            return new JsonResponse([
                'error' => $e->getPrevious()->getMessage(),
            ], 403);
        }

        $this->logger->info('Ride update finished');

        return new JsonResponse([
            'ok' => 'updated',
        ]);
    }
}
