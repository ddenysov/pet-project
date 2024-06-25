<?php

namespace User\Domain\Model\Event;

interface DomainEvent
{

    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @return string
     */
    public function getName(): string;
}