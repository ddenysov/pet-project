<?php

namespace Iam\Delivery\Http\Controller;

use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Iam\Delivery\Http\Request\Dto\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class HealthCheckController extends Controller
{
    /**
     * @return JsonResponse
     */
    #[Route('/hepetalth-check', name: 'health-check', methods: ['POST', 'GET'], format: 'json')]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse('ok');
    }
}
