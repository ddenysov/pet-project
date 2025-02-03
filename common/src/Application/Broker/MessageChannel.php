<?php

namespace Common\Application\Broker;

class MessageChannel implements Port\MessageChannel
{

    public function __construct(private string $name, private array $settings)
    {
    }

    #[\Override] public function getName(): string
    {
        return $this->name;
    }

    #[\Override] public function getSettings(): array
    {
        return $this->settings;
    }

}