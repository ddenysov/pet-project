<?php

namespace Common\Infrastructure\Security\Symfony;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class AuthGateListener
{

    public function __construct()
    {
    }

    public function onKernelController(ControllerEvent $event)
    {
        $request = $event->getRequest();
        $controller = $event->getController();

        dd($controller);


        $event->setController(function() {
            return new JsonResponse('Access Denied', 403);
        });
    }
}