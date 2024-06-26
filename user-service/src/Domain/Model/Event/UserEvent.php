<?php

namespace User\Domain\Model\Event;

use User\Domain\Model\ValueObject\DateTime;
use User\Domain\Model\ValueObject\UserId;
use User\Domain\Model\ValueObject\UserName;
use User\Domain\Model\ValueObject\UUID;
use function Symfony\Component\Clock\now;

abstract readonly class UserEvent implements DomainEvent
{
    /**
     * @var DateTime
     */
    private DateTime $createdAt;

    /**
     * @var UUID
     */
    private UUID $eventId;

    /**
     * @param UserId $id
     * @param UserName $name
     */
    public function __construct(
        private readonly UserId $id,
        private readonly UserName $name,
    ) {
        $this->createdAt = new DateTime();
        $this->eventId = UUID::generate();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id->toString(),
            'name' => $this->name->toString(),
        ];
    }

    public function getEventId(): UUID
    {
        return $this->eventId;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
}