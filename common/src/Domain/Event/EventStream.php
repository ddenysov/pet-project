<?php

namespace Common\Domain\Event;

use Common\Utils\Collection\Collection;

class EventStream extends Collection implements Port\EventStream
{
    #[\Override] protected function getClass(): string
    {
        return Event::class;
    }
}