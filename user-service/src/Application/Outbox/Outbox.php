<?php

namespace User\Application\Outbox;

use DateTime;
use Symfony\Component\Uid\Uuid;

class Outbox
{
    public Uuid $id;

    public string $name;

    public array $payload;

    public OutboxStatus $status;

    public DateTime $createdAt;

    /**
     * @param Uuid $id
     * @param string $name
     * @param array $payload
     * @param OutboxStatus $status
     * @param DateTime $createdAt
     */
    public function __construct(Uuid $id, string $name, array $payload, OutboxStatus $status, DateTime $createdAt)
    {
        $this->id        = $id;
        $this->name      = $name;
        $this->payload   = $payload;
        $this->status    = $status;
        $this->createdAt = $createdAt;
    }
}