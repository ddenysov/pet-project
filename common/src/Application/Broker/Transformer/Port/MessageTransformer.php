<?php

namespace Common\Application\Broker\Transformer\Port;

use Common\Application\Broker\Message;
use Common\Domain\Event\Event;

interface MessageTransformer
{
    public function supports(Event $event): bool;

    public function transform(Event $event): Message;
}