<?php

namespace Iam\Application\Handlers\Event;

use Iam\Application\Projector\Port\UserProjector;
use Iam\Domain\Event\UserRegistered;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class UserRegisteredEventHandler
{

    public function __construct(private UserProjector $projector)
    {
    }

    public function __invoke(UserRegistered $event)
    {
        $this->projector->apply($event);
    }

}