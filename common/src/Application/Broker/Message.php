<?php

namespace Common\Application\Broker;

use Common\Application\Broker\Port\MessageChannel;
use Override;

class Message implements Port\Message
{
    /**
     * @param string $id
     * @param string $event_id
     * @param string $name
     * @param array $payload
     * @param MessageChannel $channel
     * @param string $status
     * @param \DateTime|null $createdAt
     */
    public function __construct(
        private string $id,
        private string $event_id,
        private string $name,
        private array $payload,
        private MessageChannel $channel,
        private string $status = 'pending',
        private ?\DateTime $createdAt = null,
    )
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEventId(): string
    {
        return $this->event_id;
    }

    public function getName(): string
    {
        return $this->name;
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
     * @return \DateTime|null
     */
    #[\Override] public function getCreateAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTime $dateTime): void
    {
        $this->createdAt = $dateTime;
    }

    #[\Override] public function getChannel(): MessageChannel
    {
        return $this->channel;
    }
}