<?php
declare(strict_types=1);

namespace Tests\Domain\Entity;

use PHPUnit\Framework\TestCase;
use Tests\Domain\Entity\Stub\StubEntity;
use Tests\Domain\Entity\Stub\StubId;
use Tests\Domain\Entity\Stub\StubString;

final class EntityTest extends TestCase
{
    public function testGreetsWithName(): void
    {
        $id = StubId::create();
        $name = new StubString('test');

        $stub = new StubEntity(
            id: $id,
            name: $name
        );

        $this->assertEquals($id->toString(), $stub->toArray()['id']);
        $this->assertEquals($name->toString(), $stub->toArray()['name']);
        $this->assertEquals($id->toString(), $stub->getId()->toString());
        $this->assertTrue($stub->getId()->equals($id));
        $this->assertTrue($stub->getName()->equals($name));
    }
}