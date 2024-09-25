<?php

namespace Common\Infrastructure\Exception\Symfony;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        $statusCode = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : JsonResponse::HTTP_INTERNAL_SERVER_ERROR;

        $exception = $event->getThrowable();
        $previous  = $exception->getPrevious();

        if ($previous instanceof ValidationFailedException || $exception instanceof ValidationFailedException) {
            /**
             * @var ValidationFailedException $previous
             */
            $violations = $previous?->getViolations() ?? $exception->getViolations();
            $response   = [];

            foreach ($violations as $error) {
                $key = trim($error->getPropertyPath(), '[]');
                $item = [
                    'message' => $error->getMessage(),
                    'key'     => $key,
                ];

                $response[$key] = $item;
            }

            $response = new JsonResponse([
                'code'   => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => $response,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);

            $event->setResponse($response);

            return;
        }

        $response = new JsonResponse([
            'success' => false,
            'error'   => $exception->getMessage(),
            'trace'   => $exception->getTrace(),
        ], $statusCode);

        $event->setResponse($response);
    }
}