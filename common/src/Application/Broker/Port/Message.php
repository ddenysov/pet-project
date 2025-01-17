<?php

namespace Common\Application\Broker\Port;

interface Message
{
    public function getId(): string;
    public function getPayload(): array;
    public function markDone(): void;
}