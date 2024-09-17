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
     * @return JsonResponse
     */
    #[Route('/health-check', name: 'health-check', methods: ['POST', 'GET'], format: 'json')]
    public function __invoke(HubInterface $hub): JsonResponse
    {
        $this->logger->info('Healthcheck started');
        //$this->queryBus->execute(new HealthCheckQuery(time()));
        //$this->commandBus->execute(new HealthCheckCommand());

        $update = new Update(
            'https://example.com/books/1',
            json_encode(['status' => 'OutOfStock'])
        );

        $hub->publish($update);

        return new JsonResponse([
            'ok' => date('Y-m-d H:i:s'),
        ]);
    }
}
