<?php

namespace Common\Application\Handlers\Command;

use Common\Utils\Serialize\Trait\ObjectToArray;
use ReflectionClass;

abstract class Command implements Port\Command
{
    use ObjectToArray;
    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->propertiesToArray();
    }
}