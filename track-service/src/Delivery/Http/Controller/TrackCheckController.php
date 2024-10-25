<?php

namespace Track\Delivery\Http\Controller;

use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Track\Delivery\Http\Request\CreateTrackRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class TrackCheckController extends Controller
{
    /**
     * @param CreateTrackRequest $request
     * @return JsonResponse
     */
    #[Route('/create', name: 'create', methods: ['POST', 'GET'], format: 'json')]
    public function __invoke(CreateTrackRequest $request): JsonResponse
    {
        return new JsonResponse([
            'ok' => date('Y-m-d H:i:s'),
        ]);
    }
}
