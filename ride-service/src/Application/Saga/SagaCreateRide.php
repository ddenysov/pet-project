<?php

namespace Ride\Application\Saga;

use Common\Domain\Event\Event;

class SagaCreateRide
{
    public function handle(Event $event)
    {

    }

    public function defineSteps(): array
    {
        // питання, івенти може слати і агррегат також, може не вказувати івент просто тригер та екшен
        return [
            [
                'action'  => 'createRideRequest',
                'trigger' => 'StartSaga',
                'event'   => 'RideRequestCreated',
            ],
            [
                'action'  => 'requestOrganizerDetails',
                'trigger' => 'RideRequestCreated',
                'event'   => 'UserDetailsRequested',
            ],
            [
                'action'  => 'receiveOrganizerDetails',
                'trigger' => 'UserDetailsReceived',
                'event'   => 'TrackDetailsRequested',
            ],
            [
                'action'  => 'receiveTrackDetails',
                'trigger' => 'TrackDetailsReceived',
                'event'   => 'TrackDetailsRequested',
            ],
        ];
    }
}