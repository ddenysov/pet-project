<?php

namespace Iam\Application\Handlers\Event;

use Iam\Domain\Event\UserRegistered;
use Iam\Domain\Repository\Port\ReadModel\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class UserRegisteredEventHandler
{

    public function __construct(UserRepository $userRepository)
    {
    }

    #[AsMessageHandler]
    public function __invoke(UserRegistered $event)
    {
        dd($event);
    }

}