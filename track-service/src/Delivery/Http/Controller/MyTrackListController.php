<?php

namespace Track\Delivery\Http\Controller;

use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Symfony\Component\HttpFoundation\Request;
use Track\Application\Query\TrackListQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MyTrackListController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/list/my', name: 'my-list', methods: ['POST', 'GET'], format: 'json')]
    public function __invoke(Request $request): JsonResponse
    {
        $result = $this->queryBus->execute(new TrackListQuery(
            pageSize: 100,
            filters: [['owner_id', $this->getIdentity()->getId()->toString()]]
        ));

        $data   = array_map(function ($value) {
            unset($value['path']);

            return $value;
        }, $result);

        return new JsonResponse([
            'data'    => $data,
        ]);
    }
}
