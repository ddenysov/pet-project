<?php

namespace Common\Application\Broker\Port;

interface Message
{
    public function getId(): ?string;
    public function getEventId(): string;
    public function getName(): string;
    public function getPayload(): array;
    public function complete(): void;
    public function getStatus(): string;
    public function getCreateAt(): ?\DateTime;
    public function getChannel(): MessageChannel;
}