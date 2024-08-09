<?php

namespace Common\Domain\Event;

use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Uuid;
use Common\Utils\Serialize\Trait\ObjectToArray;

abstract class Event implements Port\Event
{
    use ObjectToArray;

    /**
     * @var Uuid
     */
    protected Uuid $id;

    protected Uuid $aggregateId;

    /**
     * @throws InvalidUuidException
     */
    public function __construct()
    {
        $this->id = Uuid::create();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @param Uuid $id
     * @return void
     */
    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        $name = get_class($this);
        $parts = explode('\\', $name);
        $parts = array_map(function ($input) {
            return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
        }, $parts);

        return implode('.', $parts);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->propertiesToArray();
    }

    public function getAggregateId(): Uuid
    {
        return $this->aggregateId;
    }

    public function setAggregateId(Uuid $id): void
    {
        $this->aggregateId = $id;
    }
}