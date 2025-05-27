<?php

declare(strict_types=1);

namespace Zinc\Core\Domain\Event;

use Zinc\Core\Support\Collection\AbstractCollection;

class EventStream extends AbstractCollection implements EventStreamInterface
{
    #[\Override]
    protected function getClass(): string
    {
        return EventInterface::class;
    }
}
