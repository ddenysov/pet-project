<?php

declare(strict_types=1);

namespace Zinc\Core\Support\Collection;

abstract class AbstractCollection implements \Iterator, \ArrayAccess, Collection, \Countable
{
    private array $container = [];

    private int $position = 0;

    public function __construct(array $collection = [])
    {
        $class = $this->getClass();
        $this->container = \array_map(function ($value) use ($class) {
            if ($this->offsetCheck($value)) {
                return $value;
            }
            return new $class(...$value);
        }, $collection);
    }

    public function offsetSet($offset, $value): void
    {
        if (!$this->offsetCheck($value)) {
            throw new \InvalidArgumentException("Value must implement the Event interface.");
        }

        if (\is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetCheck(mixed $value): bool
    {
        return \is_a($value, $this->getClass(), true);
    }

    public function offsetGet($offset): mixed
    {
        return $this->container[$offset] ?? null;
    }

    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    // Удаляет значение по ключу
    public function offsetUnset($offset): void
    {
        unset($this->container[$offset]);
    }

    public function current(): mixed
    {
        return $this->container[$this->position];
    }

    public function key(): mixed
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return isset($this->container[$this->position]);
    }

    #[\Override]
    public function count(): int
    {
        return \count($this->container);
    }

    abstract protected function getClass(): string;
}
