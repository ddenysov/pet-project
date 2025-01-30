<?php

namespace Common\Application\Broker;

use Common\Utils\Collection\Collection;

class MessageCollection extends Collection implements Port\MessageCollection
{
    #[\Override] public function offsetCheck(mixed $value): bool
    {
        return $value instanceof Message;
    }
}