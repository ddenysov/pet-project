<?php

namespace Common\Application\EventHandler\Message;

class TimeoutMessage implements Port\Message
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'event.timeout';
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return [];
    }
}