<?php
declare(strict_types=1);

namespace Tests\Domain\Entity;

use Common\Domain\ValueObject\Uuid;
use PHPUnit\Framework\TestCase;
use Tests\Mock\Domain\Entity\StubEntity;
use Tests\Mock\Domain\Entity\StubId;
use Tests\Mock\Domain\Entity\StubString;

final class EntityTest extends TestCase
{
    public function testCase1(): void
    {
        $stub = new StubEntity(
            StubId::create(),
            new StubString('test'),
        );

        $this->assertTrue(\Symfony\Component\Uid\Uuid::isValid($stub->toArray()['id']));
        $this->assertEquals('test', $stub->toArray()['name']);
        $this->assertTrue($stub->getId()->equals(Uuid::fromString($stub->toArray()['id'])));
        $this->assertTrue($stub->getName()->equals(new StubString($stub->toArray()['name'])));
    }
}