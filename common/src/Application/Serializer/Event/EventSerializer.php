<?php

namespace Common\Application\Serializer\Event;

use Common\Domain\Event\Port\Event;
use Common\Domain\ValueObject\Uuid;
use ReflectionClass;

class EventSerializer
{
    /**
     * @param string $name
     * @param array $payload
     * @return Event
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
            $arg         = new $argTypeName($payload[$parameter->getName()]);
            $args[]      = $arg;
        }

        /**
         * @var Event $event
         */
        $event = $reflectionClass->newInstanceArgs($args);
        $event->setId(Uuid::fromString($payload['id']));
        $event->setAggregateId(Uuid::fromString($payload['aggregateId']));

        return $event;
    }

    /**
     * @param string $eventName
     * @return string
     */
    private function getClassName(string $eventName): string
    {
        $parts = explode('.', $eventName);
        $parts = array_map(function ($input) {
            return str_replace('_', '', ucwords($input, '_'));
        }, $parts);

        return implode('\\', $parts);
    }
}