<?php

namespace App\Tests\Domain\ValueObject;

use User\Domain\Model\ValueObject\UserId;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class UserIdTest extends TestCase
{
    public function testCreateIdFromString(): void
    {
        $uuidString = '01900895-cca9-7e24-bdd7-ec98790f5242';
        $userId = new UserId($uuidString);

        $this->assertEquals($uuidString, $userId->toString());
    }

    /**
     * @throws \Exception
     */
    public function testGenerateNewId(): void
    {
        $userId = UserId::generate();

        $this->assertTrue(Uuid::isValid($userId->toString()));
    }
}