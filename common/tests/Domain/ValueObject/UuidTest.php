<?php
declare(strict_types=1);

namespace Tests\Domain\ValueObject;

use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Uuid;
use Common\Infrastructure\Uuid\Symfony\UuidAdapter;
use PHPUnit\Framework\TestCase;

final class UuidTest extends TestCase
{
    public function testCase1(): void
    {
        $uuid = Uuid::create();
        $this->assertTrue(UuidAdapter::isValid($uuid->toString()));
    }

    public function testCase2(): void
    {
        $this->expectException(InvalidUuidException::class);
        new Uuid('123');
    }

    /**
     * @throws InvalidUuidException
     */
    public function testCase3(): void
    {
        $uuidString = UuidAdapter::create();
        $uuid = new Uuid($uuidString);
        $this->assertEquals($uuidString, $uuid->toString());
    }
}