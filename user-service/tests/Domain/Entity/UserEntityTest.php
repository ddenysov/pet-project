<?php

namespace App\Tests\Domain\Entity;

use User\Domain\Model\Entity\User;
use User\Domain\Model\ValueObject\UserId;
use PHPUnit\Framework\TestCase;
use User\Domain\Model\ValueObject\UserName;

final class UserEntityTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testCreateIdFromString(): void
    {
        $uuidString = '01900895-cca9-7e24-bdd7-ec98790f5242';
        $user       = new User(
            id: new UserId($uuidString),
            name: new UserName('TestUser'),
        );

        $this->assertEquals($uuidString, $user->getId()->toString());
    }
}