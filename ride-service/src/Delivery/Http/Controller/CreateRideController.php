<?php

namespace Ride\Delivery\Http\Controller;

use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Ride\Application\Handlers\Command\CreateRideCommand;
use Ride\Delivery\Http\Request\Dto\CreateRideRequest;
use Ride\Delivery\Http\Security\CanCreateRide;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class CreateRideController extends Controller
{
    /**
     * @param CreateRideRequest $ride
     * @param Request $request
     * @return JsonResponse
     * @throws \ReflectionException
     */
    #[Route('/create-ride', name: 'create-ride', methods: ['POST', 'GET'], format: 'json')]
    #[CanCreateRide()]
    public function __invoke(
        Request $request
    ) {
        $validator = Validation::createValidator();


        $groups = new Assert\GroupSequence(['Default', 'custom']);

        $constraint = new Assert\Collection([
            // the keys correspond to the keys in the input array
            'name' => new Assert\Email(),
        ]);

        $violations = $validator->validate($request->toArray(), $constraint, $groups);


        dd($violations);

        $this->logger->debug('Request received', [
            'data' => $request->toArray(),
            'headers' => $request->headers->all(),
        ]);
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
