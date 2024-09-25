<?php

namespace Ride\Delivery\Http\Controller;

use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Ride\Application\Handlers\Command\CreateRideCommand;
use Ride\Delivery\Http\Request\CreateRideRequest;
use Ride\Delivery\Http\Security\CanCreateRide;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class CreateRideController extends Controller
{
    #[Route('/create-ride', name: 'create-ride', methods: ['POST', 'GET'], format: 'json')]
    #[CanCreateRide()]
    public function __invoke(
        CreateRideRequest $request
    ) {
        $this->logger->info('Ride created');
        $this->commandBus->execute(new CreateRideCommand(
            organizerId: $this->getIdentity()->getId()->toString(),
            name: $ride->name
        ));

        return new JsonResponse([
            'ok' => 'created',
        ]);
    }
}
