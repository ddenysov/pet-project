<?php

namespace Iam\Application\Handlers\Event;

use Iam\Application\Projector\Port\UserProjector;
use Iam\Domain\Event\UserPasswordResetRequested;

class UserPasswordRequestedEventHandler
{

    public function __construct()
    {
    }

    public function __invoke(UserPasswordResetRequested $event)
    {
        $this->projector->apply($event);
    }

}