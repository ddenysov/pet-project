<?php

namespace Zinc\Core\Domain\Event;

use Zinc\Core\Support\Collection\AbstractCollection;

class EventStream extends AbstractCollection
{
    #[\Override] protected function getClass(): string
    {
        return Event::class;
    }
}