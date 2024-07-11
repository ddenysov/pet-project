<?php
declare(strict_types=1);

namespace Tests\Domain\Entity;

use PHPUnit\Framework\TestCase;
use Tests\Domain\Entity\Stub\StubEntity;
use Tests\Domain\Entity\Stub\StubId;

final class EntityTest extends TestCase
{
    public function testGreetsWithName(): void
    {
        $id = StubId::create();

        $stub = new StubEntity(
            id: $id,
        );

        $this->assertEquals($id->toString(), $stub->toArray()['id']);
        $this->assertEquals($id->toString(), $stub->getId()->toString());
        $this->assertTrue($stub->getId()->equals($id));
    }
}