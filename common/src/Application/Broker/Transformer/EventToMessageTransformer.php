<?php

namespace Common\Application\Broker\Transformer;

use Common\Application\Broker\Message;
use Common\Domain\Event\Event;

class EventToMessageTransformer
{

    public function __construct(private SchemaRegistry $registry)
    {
    }

    public function transform(Event $event): Message
    {

    }
}