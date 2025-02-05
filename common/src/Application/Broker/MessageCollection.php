<?php

namespace Common\Application\Broker;

use Common\Utils\Collection\Collection;

class MessageCollection extends Collection implements Port\MessageCollection
{
    #[\Override] protected function getClass(): string
    {
        return Message::class;
    }
}