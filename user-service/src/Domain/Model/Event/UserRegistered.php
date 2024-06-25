<?php

namespace User\Domain\Model\Event;

readonly final class UserRegistered extends UserEvent
{
    public function getName(): string
    {
        return 'user.registered';
    }
}