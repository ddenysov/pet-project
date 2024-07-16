<?php

namespace Common\Domain\Event;

class EventCollection
{
    protected array $events = [];

    /**
     * @param $event
     * @return void
     */
    public function add($event)
    {
        $this->events[] = $event;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->events;
    }
}