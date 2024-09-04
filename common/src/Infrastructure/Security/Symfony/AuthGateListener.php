<?php

namespace Common\Infrastructure\Security\Symfony;

use Common\Delivery\Http\Security\Port\Policy;
use ReflectionMethod;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class AuthGateListener
{
    public function onKernelController(ControllerEvent $event)
    {
        $request = $event->getRequest();
        $controller = $event->getController();

        $reflectionMethod = new ReflectionMethod($controller::class, '__invoke');
        $attributes = $reflectionMethod->getAttributes();

        dump($attributes);

        foreach ($attributes as $attribute) {
            $attributeClassName = $attribute->getName();
            $interfaces = class_implements($attributeClassName);

            if(in_array(Policy::class, $interfaces)) {
                dump($attribute->newInstance());
            }
        }

        dd();

        $event->setController(function() {
            return new JsonResponse('Access Denied', 403);
        });
    }
}