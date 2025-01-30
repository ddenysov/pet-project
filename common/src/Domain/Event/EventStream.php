<?php

namespace Common\Domain\Event;

use Common\Utils\Collection\Collection;

class EventStream extends Collection implements Port\EventStream
{
    #[\Override] public function offsetCheck(mixed $value): bool
    {
        return $value instanceof Event;
    }
}