<?php

namespace Common\Application\Broker;

use Common\Application\Broker\Port\MessageChannel;
use Override;

class Message implements Port\Message
{
    private \DateTime $createdAt;

    /**
     * @param string $id
     * @param array $payload
     * @param string $status
     * @param \DateTime|null $createdAt
     */
    public function __construct(
        private string $id,
        private array $payload,
        private string $status = 'pending',
        \DateTime $createdAt = null,
    )
    {
        $this->createdAt = $createdAt ?? new \DateTime();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    #[Override] public function complete(): void
    {
        $this->status = 'complete';
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return \DateTime
     */
    #[\Override] public function getCreateAt(): \DateTime
    {
        return $this->createdAt;
    }

    #[\Override] public function getChannel(): MessageChannel
    {
        return new \Common\Application\Broker\MessageChannel();
    }
}