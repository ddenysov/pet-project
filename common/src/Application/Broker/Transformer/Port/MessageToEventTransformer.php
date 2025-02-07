<?php

namespace Common\Application\Broker\Transformer\Port;

use Common\Application\Broker\Message;
use Common\Domain\Event\Event;

interface MessageToEventTransformer
{
    public function supports(string $eventName, int $schemaVersion): bool;

    public function transform(Message $message): Event;
}