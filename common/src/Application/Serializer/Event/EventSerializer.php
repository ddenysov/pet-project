<?php

namespace Common\Application\Serializer\Event;

use Common\Domain\Event\Port\Event;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Uuid;
use ReflectionClass;

class EventSerializer
{
    /**
     * @var array
     */
    private array $registry = [];

    /**
     * @param string $name
     * @param array $payload
     * @return Event
     * @throws InvalidUuidException
     * @throws \ReflectionException
     */
    public function deserialize(string $name, array $payload): Event
    {
        /**
         * @var Event $className
         */
        $className       = $this->getClassName($name);
        $reflectionClass = new ReflectionClass($className);
        $constructor     = $reflectionClass->getConstructor();
        $parameters      = $constructor->getParameters();

        $args = [];

        foreach ($parameters as $parameter) {
            $argTypeName = $parameter->getType()->getName();
            $value = $payload[$parameter->getName()];
            if (is_array($value)) {
                $value = json_encode($value);
            }
            $arg         = $argTypeName::deserialize($value);
            $args[]      = $arg;
        }

        /**
         * @var Event $event
         */
        $event = $reflectionClass->newInstanceArgs($args);
        $event->setEventId(Uuid::fromString($payload['eventId']));
        $event->setAggregateId(Uuid::fromString($payload['aggregateId']));

        return $event;
    }

    /**
     * @param string $eventName
     * @return string
     */
    private function getClassName(string $eventName): string
    {
        if (isset($this->registry[$eventName])) {
            return $this->registry[$eventName];
        }

        $parts = explode('.', $eventName);
        $parts = array_map(function ($input) {
            return str_replace('_', '', ucwords($input, '_'));
        }, $parts);

        return implode('\\', $parts);
    }

    public static function getRegistry(): array
    {
        return self::$registry;
    }

    /**
     * @param string $event
     * @param string $class
     * @return void
     */
    public function registerExternalEvent(string $event, string $class): void
    {
        $this->registry[$event] = $class;
    }
}