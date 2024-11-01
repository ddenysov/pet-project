<?php

namespace Track\Delivery\Http\Controller;

use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Track\Application\Command\CreateTrackCommand;
use Track\Application\Query\TrackListQuery;
use Track\Delivery\Http\Request\CreateTrackRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class TrackListController extends Controller
{
    /**
     * @return JsonResponse
     */
    #[Route('/list', name: 'list', methods: ['POST', 'GET'], format: 'json')]
    public function __invoke(): JsonResponse
    {
        $result = $this->queryBus->execute(new TrackListQuery());
        $data   = array_map(function ($value) {
            unset($value['path']);

            return $value;
        }, $result);

        return new JsonResponse([
            'data'    => $data,
            'page'    => [
                'current' => 1,
                'total'   => 20,
                'size'    => 5,
            ],
            'records' => [
                'filtered' => 50,
                'total'    => 100,
            ],
        ]);
    }
}
