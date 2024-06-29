<?php

namespace User\Application\Outbox;

use User\Domain\Model\Event\DomainEvent;

interface OutboxRepository
{
    /**
     * @param Outbox $outbox
     * @return void
     */
    public function save(Outbox $outbox): void;
}