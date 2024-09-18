<?php

namespace Ride\Delivery\Http\Controller;

use Common\Application\Bus\Port\CommandBus;
use Common\Application\Bus\Port\QueryBus;
use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;
use Ride\Application\Handlers\Command\HealthCheckCommand;
use Ride\Application\Handlers\Query\HealthCheckQuery;


class HealthCheckController extends Controller
{
    /**
     * @param HubInterface $hub
     * @return JsonResponse
     */
    #[Route('/health-check', name: 'health-check', methods: ['POST', 'GET'], format: 'json')]
    public function __invoke(HubInterface $hub): JsonResponse
    {
        $this->logger->info('Healthcheck started');
        //$this->queryBus->execute(new HealthCheckQuery(time()));
        //$this->commandBus->execute(new HealthCheckCommand());

        $update = new Update(
            'https://updates/user/123',
            json_encode([
                'entity' => 'rides',
                'id' => '123',
            ])
        );

        $hub->publish($update);

        return new JsonResponse([
            'ok' => date('Y-m-d H:i:s'),
        ]);
    }
}
