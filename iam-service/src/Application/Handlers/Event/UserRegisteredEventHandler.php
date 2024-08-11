<?php

namespace Iam\Application\Handlers\Event;

use Iam\Application\Projector\Port\UserProjector;
use Iam\Domain\Event\UserRegistered;
use Iam\Domain\Repository\Port\ReadModel\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class UserRegisteredEventHandler
{

    public function __construct(private UserProjector $projector)
    {
    }

    #[AsMessageHandler]
    public function __invoke(UserRegistered $event)
    {
        $this->projector->apply($event);
    }

}