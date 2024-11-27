<?php

namespace Ride\Delivery\Http\Controller;

use Common\Application\Client\Port\PrivateClient;
use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Routing\Annotation\Route;


class TestCheckController extends Controller
{
    /**
     * @param HubInterface $hub
     * @return JsonResponse
     */
    #[Route('/test', name: 'test', methods: ['POST', 'GET'], format: 'json')]
    public function __invoke(HubInterface $hub, PrivateClient $client): JsonResponse
    {
        $data = $client->get('https://jsonplaceholder.typicode.com/todos/1');

        return new JsonResponse([
            'ok'   => date('Y-m-d H:i:s'),
            'data' => $data,
        ]);
    }
}
