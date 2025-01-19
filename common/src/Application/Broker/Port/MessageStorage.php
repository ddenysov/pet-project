<?php

namespace Common\Application\Broker\Port;

interface MessageStorage
{
    public function find(string $id): Message;
    public function store(Message $message): void;
    public function getLast(int $number): MessageBuffer;
}