<?php

namespace Common\Domain\Event;

use ArrayAccess;
use InvalidArgumentException;
use Iterator;

class EventStream implements Port\EventStream
{
    /**
     * @var array
     */
    private array $container = [];

    /**
     * @var int
     */
    private int $position = 0;

    /**
     * @param $offset
     * @param $value
     * @return void
     */
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

    /**
     * @param $offset
     * @return mixed
     */
    public function offsetGet($offset): mixed {
        return $this->container[$offset] ?? null;
    }

    /**
     * @param $offset
     * @return bool
     */
    // Проверяет существование ключа
    public function offsetExists($offset): bool {
        return isset($this->container[$offset]);
    }

    /**
     * @param $offset
     * @return void
     */
    // Удаляет значение по ключу
    public function offsetUnset($offset): void {
        unset($this->container[$offset]);
    }

    /**
     * @return mixed
     */
    public function current(): mixed {
        return $this->container[$this->position];
    }

    /**
     * @return mixed
     */
    public function key(): mixed {
        return $this->position;
    }

    /**
     * @return void
     */
    public function next(): void {
        ++$this->position;
    }

    /**
     * @return void
     */
    public function rewind(): void {
        $this->position = 0;
    }

    /**
     * @return bool
     */
    public function valid(): bool {
        return isset($this->container[$this->position]);
    }
}