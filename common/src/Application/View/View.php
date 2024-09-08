<?php

namespace Common\Application\View;

use JsonSerializable;

abstract readonly class View implements JsonSerializable
{
    /**
     * @param array $data
     */
    public function __construct(protected array $data = [])
    {
    }

    /**
     * @return array
     */
    abstract public function toArray(): array;

    /**
     * @return mixed
     */
    final public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    /**
     * @param string $name
     * @return mixed|void
     */
    final public function __get(string $name)
    {
        $data = $this->toArray();

        if (isset($data[$name])) {
            return $data[$name];
        }
    }

    /**
     * @param array $collection
     * @return array
     */
    final public static function collection(array $collection): array
    {
        return [
            'data' => array_map(function (array $item) {
                return new static($item);
            }, $collection)
        ];
    }
}