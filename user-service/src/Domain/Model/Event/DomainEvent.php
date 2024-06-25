<?php

namespace User\Domain\Model\Event;

interface DomainEvent
{
    public function toArray(): array;
}