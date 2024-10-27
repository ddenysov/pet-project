<?php

namespace Track\Domain\ValueObject;

use Common\Domain\ValueObject\ValueObject;

class TrackAccessType extends ValueObject
{
    public const PUBLIC = 'public';

    public const PRIVATE = 'private';

    /**
     * @param string $value
     * @throws \Exception
     */
    public function __construct(private readonly string $value)
    {
        if (!in_array($this->value, [
            self::PRIVATE,
            self::PUBLIC
        ])) {
            throw new \Exception('Wrong access value');
        }
    }

    public function toString(): string
    {
        return $this->value;
    }
}