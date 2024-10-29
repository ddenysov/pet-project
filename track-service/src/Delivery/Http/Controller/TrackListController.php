<?php

namespace Track\Delivery\Http\Controller;

use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Track\Application\Command\CreateTrackCommand;
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
        return new JsonResponse([
            'ok' => date('Y-m-d H:i:s'),
        ]);
    }
}
