<?php

namespace Ride\Delivery\Http\Controller;

use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Ride\Application\Handlers\Command\CreateRideCommand;
use Ride\Application\Handlers\Command\UpdateRideCommand;
use Ride\Delivery\Http\Request\Dto\NewRideInfo;
use Ride\Delivery\Http\Request\Dto\UpdatedRideRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Ride\Application\Handlers\Command\HealthCheckCommand;
use Ride\Application\Handlers\Query\HealthCheckQuery;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;


class UpdateRideController extends Controller
{
    /**
     * @param UpdatedRideRequest $request
     * @return JsonResponse
     * @throws \ReflectionException
     */
    #[Route('/update-ride', name: 'update-ride', methods: ['POST', 'GET'], format: 'json')]
    public function __invoke(
        #[MapQueryString] UpdatedRideRequest $request,
    )
    {
        // has token
        // has request data GET POST
        // using request data need to find read model
        // - find by what - implement in policy


        $ride = $this->queryBus->execute(new FindByIdQuery($request->id));
        $hasAccess = (new CanUpdateRide($identity, $ride))->check();

        if (!$hasAccess) {
            return new JsonResponse('Forbidden', 403);
        }

        $this->logger->info('Ride update started');
        $this->commandBus->execute($request->transform(UpdateRideCommand::class));

        return new JsonResponse([
            'ok' => 'created',
        ]);
    }
}
