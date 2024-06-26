<?php

namespace User\Domain\Model\Event;

use User\Domain\Model\ValueObject\DateTime;
use User\Domain\Model\ValueObject\UUID;

interface DomainEvent
{

    public function getEventId(): UUID;
    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime;
}