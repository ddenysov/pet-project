<?php

namespace Iam\Delivery\Http\Controller;

use Common\Application\Bus\Port\CommandBus;
use Common\Application\Bus\Port\QueryBus;
use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class HealthCheckController extends Controller
{
    public function __construct(CommandBus $commandBus, QueryBus $queryBus, private LoggerInterface $logger)
    {
        parent::__construct($commandBus, $queryBus);
    }

    /**
     * @return JsonResponse
     */
    #[Route('/health-check', name: 'health-check', methods: ['POST', 'GET'], format: 'json')]
    public function __invoke(): JsonResponse
    {
        $this->logger->info('IAM: Healthcheck OK');
        return new JsonResponse([
            'ok' => date('Y-m-d H:i:s'),
        ]);
    }
}
