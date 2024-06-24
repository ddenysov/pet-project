<?php

namespace User\Infrastructure\Adapter\Bus\Event;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use User\Domain\Model\Event\DomainEvent;

class EventHandler
{
    public function handle(DomainEvent $event)
    {
    }
}