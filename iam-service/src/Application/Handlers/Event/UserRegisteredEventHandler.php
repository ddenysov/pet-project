<?php

namespace Iam\Application\Handlers\Event;

use Iam\Application\Projector\Port\UserRegisteredProjector;
use Iam\Domain\Event\UserRegistered;

class UserRegisteredEventHandler
{

    public function __construct(private UserRegisteredProjector $projector)
    {
    }

    public function __invoke(UserRegistered $event)
    {
        $this->projector->apply($event);
    }
}