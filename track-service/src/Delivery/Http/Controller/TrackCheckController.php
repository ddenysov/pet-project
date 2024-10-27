<?php

namespace Track\Delivery\Http\Controller;

use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Track\Application\Command\CreateTrackCommand;
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
        $this->commandBus->execute(new CreateTrackCommand(
            name: $request->get('name'),
            creatorId:  $this->getIdentity()->getId()->toString(),
            accessType: 'private',
            path: $request->get('path')
        ));
        return new JsonResponse([
            'ok' => date('Y-m-d H:i:s'),
        ]);
    }
}
