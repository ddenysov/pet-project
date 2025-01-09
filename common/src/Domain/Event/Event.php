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
     * @return string
     */
    public static function getEventName(): string
    {
        $name = static::class;
        $parts = explode('\\', $name);
        $parts = array_map(function ($input) {
            return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
        }, $parts);

        return implode('.', $parts);
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
     * @return array
     * @throws \Exception
     */
    public function payload(): array
    {
        return array_filter($this->toArray(), function (string $key) {
            return !in_array($key, ['id', 'aggregateId']);
        }, ARRAY_FILTER_USE_KEY);
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

    public static function fromArray(array $payload): static
    {
        foreach ($payload as $key => $value) {

        }
    }

    /**
     * @param string $className
     * @return bool
     */
    public function isA(string $className): bool
    {
        return get_class($this) === $className;
    }
}