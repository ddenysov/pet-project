<?php

namespace Ride\Delivery\Http\Controller;

use Common\Domain\ValueObject\Uuid;
use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Ride\Application\Command\CreateRideCommand;
use Ride\Delivery\Http\Request\CreateRideRequest;
use Ride\Delivery\Http\Security\CanCreateRide;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

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
            trackId: Uuid::create()->toString(),
            name: $request->name,
            description: $request->description,
            rules: 'Опис правил',
            equip: 'Опис єкіпірування',
            locationStartDescription: 'Макдональдс на окружній',
            dateTimeStart: $request->time_start,
            dateTimeEnd: $request->time_end,
            image: $request->image,
            locationStart: $request->start_location,
            locationFinish: $request->finish_location,
            surfaceDirt: 40,
            bikeType: ['mtb'],
            difficulty: 'medium',
            access: 'public',
            registrationType: 'open',
        ));

        return new JsonResponse([
            'ok' => 'created',
        ]);
    }
}
