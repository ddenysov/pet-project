<?php

namespace User\Application\Ports\Output\Bus;

use User\Domain\Model\Event\DomainEvent;

interface EventBus
{
    /**
     * @param DomainEvent $event
     * @return void
     */
    public function execute(DomainEvent $event): void;
}