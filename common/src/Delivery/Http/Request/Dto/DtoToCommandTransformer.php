<?php

namespace Common\Delivery\Http\Request\Dto;


use Common\Application\Handlers\Command\Port\Command;
use ReflectionClass;

class DtoToCommandTransformer
{
    /**
     * @throws \ReflectionException
     */
    public static function transform(Port\Dto $dto, string $command): Command
    {
        $dtoArray = $dto->toArray();

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