<?php

namespace User\Application\Repository;

use User\Domain\Model\Event\DomainEvent;

interface OutboxRepository
{
    /**
     * @param DomainEvent $event
     * @return void
     */
    public function save(DomainEvent $event): void;
}