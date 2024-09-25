<?php

namespace Common\Utils\Serialize\Trait;

use Common\Application\Handlers\Command\Port\Command;
use Common\Domain\ValueObject\Port\StringValue;
use ReflectionClass;

trait ObjectToArray
{
    /**
     * @param bool $deep
     * @return array
     */
    public function propertiesToArray(bool $deep = true): array
    {
        $ref = new ReflectionClass($this);
        $props = $ref->getProperties();
        $propsArray = [];

        foreach ($props as $prop) {
            if (!$prop->isInitialized($this)) {
                continue;
            }
            $value = $prop->getValue($this);
            $propsArray[$prop->getName()] = $value instanceof StringValue || !$deep ? $value->toString() : $value;
        }

        return $propsArray;
    }
}