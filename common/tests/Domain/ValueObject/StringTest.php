<?php
declare(strict_types=1);

namespace Tests\Domain\ValueObject;

use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Exception\String\InvalidStringLengthException;
use Common\Domain\ValueObject\StringValue;
use PHPUnit\Framework\TestCase;

final class StringTest extends TestCase
{
    public function testCase1(): void
    {
        $value = new StringValue('some value');
        $this->assertEquals('some value', $value->toString());
    }

    public function testCase2(): void
    {
        $this->expectException(InvalidStringLengthException::class);
        new StringValue(str_repeat('err', 255));
    }

    /**
     * @throws InvalidUuidException
     */
    public function testCase3(): void
    {
        $value1 = new StringValue('some value');
        $value2 = new StringValue('some value');
        $value3 = new StringValue('some value2');

        $this->assertTrue($value1->equals($value2));
        $this->assertFalse($value1->equals($value3));
    }
}