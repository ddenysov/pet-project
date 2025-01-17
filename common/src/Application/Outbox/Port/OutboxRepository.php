<?php

namespace Common\Application\Outbox\Port;

use Common\Application\Outbox\OutboxStatus;
use Common\Domain\ValueObject\Uuid;

interface OutboxRepository
{
    /**
     * @param Uuid $eventId
     * @param string $name
     * @param array $payload
     * @return void
     */
    public function save(
        Uuid $eventId,
        string $name,
        array $payload,
    ): void;

    /**
     * @param Uuid $eventId
     * @return void
     */
    public function complete(Uuid $eventId): void;

    /**
     * @param Uuid $eventId
     * @return void
     */
    public function fail(Uuid $eventId): void;

    /**
     * @param int $limit
     * @return array
     */
    public function getUnpublishedMessages(int|null $limit = null): array;
}