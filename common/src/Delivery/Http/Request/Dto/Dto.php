<?php

namespace Common\Delivery\Http\Request\Dto;

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
}