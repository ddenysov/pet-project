<?php

namespace App\Domain\Model\ValueObject;

class UUID
{
    private \Symfony\Component\Uid\Uuid $uuid;

    /**
     * @throws \Exception
     */
    public function __construct(string $uuidString)
    {
        if (!\Symfony\Component\Uid\Uuid::isValid($uuidString)) {
            throw new \Exception('Invalid id, should be UUID: ' . $uuidString);
        }
        $this->uuid = \Symfony\Component\Uid\Uuid::fromString($uuidString);
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    /**
     * @throws \Exception
     */
    public static function generate(): static
    {
        return new static(\Symfony\Component\Uid\Uuid::v7()->toString());
    }
}