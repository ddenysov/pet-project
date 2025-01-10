<?php

namespace Common\Domain\Event;

use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Uuid;
use Common\Utils\Serialize\Trait\ObjectToArray;

abstract class Event implements Port\Event
{
    use ObjectToArray;

    /**
     * Uniq event identifier
     * - help with deduplication
     * - tracing
     * - uniq in event store
     * @var Uuid
     */
    public Uuid $id;

    /**
     * Aggregate produced this event
     * @var Uuid
     */
    public Uuid $aggregateId;

    /**
     * @throws InvalidUuidException
     */
    public function __construct()
    {
        $this->id = Uuid::create();
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function toArray(): array
    {
        return $this->propertiesToArray();
    }

    /**
     * @return Uuid
     */
    public function getAggregateId(): Uuid
    {
        return $this->aggregateId;
    }

    public function setAggregateId(Uuid $id): void
    {
        $this->aggregateId = $id;
    }
}