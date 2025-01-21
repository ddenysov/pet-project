<?php

namespace Common\Application\Broker\Port;

interface MessageInbox
{
    public function add(Message $message): void;

    public function markSent(string $id): void;

    public function isReceived(string $id): bool;

    public function fetchIncoming(int $limit): MessageCollection;
}