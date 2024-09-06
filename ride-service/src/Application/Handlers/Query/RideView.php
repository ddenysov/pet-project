<?php

namespace Ride\Application\Handlers\Query;

use Common\Utils\Serialize\Trait\ObjectToArray;

class RideView
{
    use ObjectToArray;

    public string $id;

    public string $name;

    /**
     * @param string $id
     * @param string $name
     */
    public function __construct(string $id, string $name)
    {
        $this->id   = $id;
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->propertiesToArray();
    }

    /**
     * @param array $collection
     * @return RideView[]
     */
    public static function collection(array $collection)
    {
        return array_map(function (array $item) {
            return new static($item['id'], $item['name']);
        }, $collection);
    }
}