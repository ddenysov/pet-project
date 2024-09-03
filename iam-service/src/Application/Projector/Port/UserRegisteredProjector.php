<?php

namespace Iam\Application\Projector\Port;

use Iam\Domain\Event\UserEvent;
use Iam\Domain\Event\UserRegistered;

interface UserRegisteredProjector
{
    /**
     * @param UserRegistered $event
     * @return void
     */
    public function apply(UserRegistered $event): void;
}