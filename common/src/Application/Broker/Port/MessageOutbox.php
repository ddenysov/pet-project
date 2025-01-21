<?php

namespace Common\Application\Broker\Port;

interface MessageOutbox
{
    public function add(Message $message): void;

    public function markSent(string $id): void;

    public function isSent(string $id): bool;

    public function fetchUnsent(int $limit): MessageCollection;
}