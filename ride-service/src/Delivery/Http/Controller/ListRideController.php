<?php

namespace Ride\Delivery\Http\Controller;

use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Ride\Application\Handlers\Query\RideDataTableQuery;
use Ride\Application\Handlers\Query\RideView;
use Ride\Delivery\Http\Request\Dto\CreateRideRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


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
            orderBy: $request->get('orderBy'),
            orderDir: $request->get('orderDir'),
        ));

        return new JsonResponse([
            'data'    => RideView::collection($result->getCollection(), $this->identity),
            'records' => [
                'total' => $result->getTotal(),
            ],
        ]);
    }
}
