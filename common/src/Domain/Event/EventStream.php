<?php

namespace Common\Domain\Event;

use ArrayAccess;
use InvalidArgumentException;
use Iterator;

class EventStream implements Iterator, ArrayAccess
{
    private array $container = [];

    private int $position = 0;

    // Устанавливает значение по ключу
    public function offsetSet($offset, $value): void {
        if (!$value instanceof Port\Event) {
            throw new InvalidArgumentException("Value must implement the Event interface.");
        }

        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetGet($offset): mixed {
        return $this->container[$offset] ?? null;
    }

    // Проверяет существование ключа
    public function offsetExists($offset): bool {
        return isset($this->container[$offset]);
    }

    // Удаляет значение по ключу
    public function offsetUnset($offset): void {
        unset($this->container[$offset]);
    }

    public function current(): mixed {
        return $this->container[$this->position];
    }

    public function key(): mixed {
        return $this->position;
    }

    public function next(): void {
        ++$this->position;
    }

    public function rewind(): void {
        $this->position = 0;
    }

    public function valid(): bool {
        return isset($this->container[$this->position]);
    }
}