<?php

namespace Common\Utils\Serialize\Trait;

use Common\Domain\ValueObject\Port\ArrayValue;
use Common\Domain\ValueObject\Port\SerializableValue;
use Common\Domain\ValueObject\Port\StringValue;
use ReflectionClass;

trait ObjectToArray
{
    /**
     * @param bool $deep
     * @return array
     * @throws \Exception
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

            if ($value instanceof ArrayValue) {
                $propsArray[$prop->getName()] = $value->toArray();
            } elseif ($value instanceof StringValue || !$deep) {
                $propsArray[$prop->getName()] = $value->toString();
            } elseif ($value instanceof SerializableValue) {
                $propsArray[$prop->getName()] = $value->serialize();
            } elseif (is_scalar($value)) {
                $propsArray[$prop->getName()] = $value;
            }
        }

        return $propsArray;
    }
}