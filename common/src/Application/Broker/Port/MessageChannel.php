<?php

namespace Common\Application\Broker\Port;

interface MessageChannel
{
    public function getName(): string;

    public function getSettings(): array;
}