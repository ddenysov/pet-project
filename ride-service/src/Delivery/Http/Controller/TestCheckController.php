<?php

namespace Ride\Delivery\Http\Controller;

use Common\Application\Bus\Port\CommandBus;
use Common\Application\Bus\Port\QueryBus;
use Common\Application\Client\Port\PrivateClient;
use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;
use Ride\Application\Handlers\Command\HealthCheckCommand;
use Ride\Application\Handlers\Query\HealthCheckQuery;


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
