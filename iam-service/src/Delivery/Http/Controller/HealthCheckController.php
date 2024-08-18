<?php

namespace Iam\Delivery\Http\Controller;

use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class HealthCheckController extends Controller
{
    /**
     * @return JsonResponse
     */
    #[Route('/health-check', name: 'health-check', methods: ['POST', 'GET'], format: 'json')]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse('ok');
    }
}
