<?php

namespace Common\Application\EventHandler\Message\Port;

interface Message
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return array
     */
    public function getPayload(): array;
}