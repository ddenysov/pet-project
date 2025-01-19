<?php

namespace Common\Application\Broker;

class MessageBuffer implements \Common\Application\Broker\Port\MessageBuffer
{

    public function __construct(private array $messages)
    {
    }

    #[\Override] public function current(): mixed
    {
        // TODO: Implement current() method.
    }

    #[\Override] public function next(): void
    {
        // TODO: Implement next() method.
    }

    #[\Override] public function key(): mixed
    {
        // TODO: Implement key() method.
    }

    #[\Override] public function valid(): bool
    {
        // TODO: Implement valid() method.
    }

    #[\Override] public function rewind(): void
    {
        // TODO: Implement rewind() method.
    }
}