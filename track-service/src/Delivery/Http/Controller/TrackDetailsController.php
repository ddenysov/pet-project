<?php

namespace Track\Delivery\Http\Controller;

use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Track\Application\Command\CreateTrackCommand;
use Track\Application\Query\TrackDetailsQuery;
use Track\Application\Query\TrackListQuery;
use Track\Delivery\Http\Request\CreateTrackRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class TrackDetailsController extends Controller
{
    /**
     * @param string $id
     * @return JsonResponse
     */
    #[Route('/details/{id}', name: 'details', methods: ['POST', 'GET'], format: 'json')]
    public function __invoke(string $id): JsonResponse
    {
        $result = $this->queryBus->execute(new TrackDetailsQuery($id));

        return new JsonResponse([
            'data'    => $result,
        ]);
    }
}
