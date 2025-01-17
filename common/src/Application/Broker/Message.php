<?php

namespace Common\Application\Broker;

use Override;

class Message implements Port\Message
{
    private string $status = 'new';

    /**
     * @param string $id
     * @param array $payload
     */
    public function __construct(private string $id, private array $payload)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    #[Override] public function markDone(): void
    {
        $this->status = 'completed';
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}