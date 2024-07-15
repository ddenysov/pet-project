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

        if ($previous instanceof ValidationFailedException) {
            /**
             * @var ValidationFailedException $previous
             */
            $violations = $previous->getViolations();
            $response   = [];

            foreach ($violations as $error) {
                $item = [
                    'message' => $error->getMessage(),
                    'key'     => $error->getPropertyPath(),
                ];

                $response[$error->getPropertyPath()] = $item;
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
        ], $statusCode);

        $event->setResponse($response);
    }
}