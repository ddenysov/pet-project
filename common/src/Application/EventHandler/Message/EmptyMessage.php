<?php

namespace Common\Application\EventHandler\Message;

use Common\Application\EventHandler\Message\Port\Message as MessagePort;

class EmptyMessage implements MessagePort
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'event.empty';
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return [];
    }
}