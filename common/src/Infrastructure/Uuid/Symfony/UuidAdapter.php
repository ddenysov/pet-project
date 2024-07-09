<?php

namespace Common\Infrastructure\Uuid\Symfony;

use Symfony\Component\Uid\Uuid;

class UuidAdapter
{
    public static function create(): string
    {
        return Uuid::v4()->toString();
    }
}