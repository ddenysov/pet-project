<?php

namespace Common\Application\View;

use Common\Delivery\Http\Security\Identity;
use JsonSerializable;

abstract readonly class View implements JsonSerializable
{
    /**
     * @param array $data
     * @param Identity|null $identity
     */
    public function __construct(protected array $data, protected Identity|null $identity = null)
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
     * @param Identity|null $identity
     * @return array
     */
    final public static function collection(array $collection, Identity|null $identity = null): array
    {
        return array_map(function (array $item) use($identity) {
            return new static($item, $identity);
        }, $collection);
    }
}