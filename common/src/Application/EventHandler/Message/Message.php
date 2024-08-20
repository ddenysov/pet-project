<?php

namespace Common\Application\EventHandler\Message;

class Message implements Port\Message
{
    /**
     * @param string $name
     * @param array $payload
     */
    public function __construct(private readonly string $name, private readonly array $payload)
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return $this->payload;
    }
}