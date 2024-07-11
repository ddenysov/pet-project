<?php
declare(strict_types=1);

namespace Tests\Domain\ValueObject;

use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Exception\String\InvalidStringLengthException;
use Common\Domain\ValueObject\PasswordValue;
use Common\Domain\ValueObject\StringValue;
use PHPUnit\Framework\TestCase;

final class PasswordTest extends TestCase
{
    public function testCase1(): void
    {
        $value = new PasswordValue('some value');
        $this->assertTrue($value->check('some value'));
        $this->assertFalse($value->check('wrong'));
    }

    public function testCase2(): void
    {
        $this->expectException(InvalidStringLengthException::class);
        new PasswordValue(str_repeat('err', 255));
    }
}