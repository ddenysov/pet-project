<?php

namespace Common\Application\Broker\Port;

interface MessageRepository
{
    public function save(Message $message): void;

    public function get(): MessageCollection;

    public function find(string $id): Message;

    public function limit(int $number): self;

    public function pending(): self;
}