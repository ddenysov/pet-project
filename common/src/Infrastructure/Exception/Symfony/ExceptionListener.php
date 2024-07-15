<?php

namespace Common\Infrastructure\Exception\Symfony;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception  = $event->getThrowable();
        $statusCode = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
        $response   = new JsonResponse([
            'success' => false,
            'error'   => $exception->getMessage(),
        ], $statusCode);

        $event->setResponse($response);
    }
}