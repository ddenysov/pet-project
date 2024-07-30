<?php

namespace Common\Application\Outbox\Port;

use Common\Application\Outbox\OutboxStatus;
use Common\Domain\ValueObject\Uuid;

interface OutboxRepository
{
    /**
     * @param string $name
     * @param Uuid $eventId
     * @param Uuid $aggregateId
     * @param array $payload
     * @param OutboxStatus $status
     * @return void
     */
    public function save(
        string $name,
        Uuid $eventId,
        Uuid $aggregateId,
        array $payload,
        OutboxStatus $status
    ): void;

    /**
     * @param int $limit
     * @return array
     */
    public function getUnpublishedMessages(int $limit): array;
}