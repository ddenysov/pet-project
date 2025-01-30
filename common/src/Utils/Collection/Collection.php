<?php

namespace Common\Utils\Collection;

use Common\Domain\Event\Port\Event;
use InvalidArgumentException;

abstract class Collection implements \Iterator, \ArrayAccess
{

    /**
     * @var array
     */
    private array $container = [];

    /**
     * @var int
     */
    private int $position = 0;

    public function __construct(array $collection = [])
    {
        $this->container = $collection;
    }

    /**
     * @param $offset
     * @param $value
     * @return void
     */
    public function offsetSet($offset, $value): void {
        if (!$this->offsetCheck($value)) {
            throw new InvalidArgumentException("Value must implement the Event interface.");
        }

        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    abstract public function offsetCheck(mixed $value): bool;

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