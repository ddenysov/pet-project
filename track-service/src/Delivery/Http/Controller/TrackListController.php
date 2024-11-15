<?php

namespace Track\Delivery\Http\Controller;

use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Symfony\Component\HttpFoundation\Request;
use Track\Application\Query\TrackListQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TrackListController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/list', name: 'list', methods: ['POST', 'GET'], format: 'json')]
    public function __invoke(Request $request): JsonResponse
    {
        $result = $this->queryBus->execute(new TrackListQuery(
            page: $request->get('page') + 1,
            pageSize: $request->get('size'),
        ));

        return new JsonResponse([
            'data'    => $result->getCollection(),
            'records' => [
                'total' => $result->getTotal(),
            ],
        ]);
    }
}
