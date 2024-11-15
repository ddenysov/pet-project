<?php

namespace Ride\Delivery\Http\Controller;

use Common\Application\Serializer\Event\EventSerializer;
use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Ride\Application\Handlers\Command\CreateRideCommand;
use Ride\Application\Handlers\Query\RideDataTableQuery;
use Ride\Application\Handlers\Query\RideView;
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
        Request $request,
    )
    {
        $result = $this->queryBus->execute(new RideDataTableQuery(
            page: $request->get('page') + 1,
            pageSize: $request->get('size'),
        ));

        return new JsonResponse([
            'data'    => RideView::collection($result->getCollection(), $this->identity),
            'records' => [
                'total' => $result->getTotal(),
            ],
        ]);
    }
}
