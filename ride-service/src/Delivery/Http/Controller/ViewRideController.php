<?php

namespace Ride\Delivery\Http\Controller;

use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Ride\Application\Handlers\Query\FindRideByIdQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ViewRideController extends Controller
{
    /**
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    #[Route('/view-ride/{id}', name: 'view-ride', methods: ['POST', 'GET'], format: 'json')]
    public function __invoke(
        Request $request,
        string $id,
    )
    {
        $ride = $this->queryBus->execute(new FindRideByIdQuery($request->get('id')));

        return new JsonResponse($ride);
    }
}
