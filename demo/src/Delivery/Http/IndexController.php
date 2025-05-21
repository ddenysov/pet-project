<?php
declare(strict_types=1);

namespace Denysov\Demo\Delivery\Http;

use Symfony\Component\HttpFoundation\JsonResponse;

class IndexController
{
    public function __invoke()
    {
        return new JsonResponse(['framework' => 'symfony']);
    }
}