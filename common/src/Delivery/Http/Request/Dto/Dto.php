<?php

namespace Common\Delivery\Http\Request\Dto;

use Common\Application\Handlers\Command\Port\Command;
use ReflectionClass;

abstract class Dto implements Port\Dto
{
    public function toArray(): array
    {
        $ref = new ReflectionClass(get_class($this));
        $props = $ref->getProperties();
        $result = [];

        foreach ($props as $prop) {
            if ($prop->isPublic()) {
                $result[$prop->getName()] = $prop->getValue($this);
            }
        }

        return $result;
    }

    /**
     * @throws \ReflectionException
     */
    public function transform(string $command): Command
    {
        $dtoArray = $this->toArray();

        $ref = new ReflectionClass($command);
        $props = $ref->getProperties();
        $propsArray = [];

        foreach ($props as $prop) {
            if ($prop->isPublic()) {
                $propsArray[$prop->getName()] = $dtoArray[$prop->getName()];
            }
        }

        return new $command(...$propsArray);
    }
}