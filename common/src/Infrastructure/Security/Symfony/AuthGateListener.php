<?php

namespace Common\Infrastructure\Security\Symfony;

use Common\Application\Auth\Port\TokenDecoder;
use Common\Delivery\Http\Security\Identity;
use Common\Delivery\Http\Security\Port\Policy;
use Common\Domain\ValueObject\Uuid;
use ReflectionMethod;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class AuthGateListener
{
    public function __construct(
        private readonly Identity $identity,
        private readonly TokenDecoder $decoder,
    ) {
    }

    public function onKernelController(ControllerEvent $event)
    {
        $request = $event->getRequest();
        $controller = $event->getController();

        $reflectionMethod = new ReflectionMethod($controller::class, '__invoke');
        $attributes = $reflectionMethod->getAttributes();

        $this->initIdentity($request);


        $this->identity->setRoles(['ROLE_ORGANIZER']);

        /**
        dump($request->headers->get('authorization'));

        foreach ($attributes as $attribute) {
            $attributeClassName = $attribute->getName();
            $interfaces = class_implements($attributeClassName);

            if(in_array(Policy::class, $interfaces)) {
                dump($attribute->newInstance());
            }
        }

        /
        dd();

        $event->setController(function() {
            return new JsonResponse('Access Denied', 403);
        });
         */
    }

    /**
     * @param Request $request
     * @return void
     */
    private function initIdentity(Request $request): void
    {
        $bearer = $request->headers->get('authorization');

        if (!$bearer) {
            return;
        }

        $token = str_ireplace('Bearer ', '', $bearer);
        $data = $this->decoder->execute($token, 'ololo');


        $this->identity->setId(Uuid::fromString($data['id']));
    }
}