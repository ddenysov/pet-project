<?php

namespace Track\Delivery\Http\Controller;

use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Track\Application\Command\HealthCheckCommand;
use Track\Application\Query\HealthCheckQuery;


class HealthCheckController extends Controller
{
    /**
     * @return JsonResponse
     */
    #[Route('/health-check', name: 'health-check', methods: ['POST', 'GET'], format: 'json')]
    public function __invoke(): JsonResponse
    {
        $this->queryBus->execute(new HealthCheckQuery(time()));
        $this->commandBus->execute(new HealthCheckCommand());

        return new JsonResponse([
            'ok' => date('Y-m-d H:i:s'),
        ]);
    }
}
