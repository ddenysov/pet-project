<?php

namespace Common\Application\Broker\Transformer\Port;

use Common\Application\Broker\Message;
use Common\Domain\Event\Event;

interface EventToMessageTransformer
{
    public function supports(Event $event): bool;

    public function transform(Event $event): Message;
}