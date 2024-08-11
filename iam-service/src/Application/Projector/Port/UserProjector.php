<?php

namespace Iam\Application\Projector\Port;

use Iam\Domain\Event\UserEvent;

interface UserProjector
{
    /**
     * @param UserEvent $event
     * @return void
     */
    public function apply(UserEvent $event): void;
}