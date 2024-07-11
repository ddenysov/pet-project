<?php

namespace Tests\Domain\Entity;

use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Iam\Domain\Entity\User;
use Iam\Domain\ValueObject\UserId;
use Iam\Domain\ValueObject\UserPassword;
use PHPUnit\Framework\TestCase;

class UserEntityTest extends TestCase
{
    /**
     * @throws InvalidUuidException
     */
    public function testCase1()
    {
        $userId = UserId::create();
        $entity = new User(
            id: $userId,
            password: new UserPassword('some password'),
        );
        $this->assertTrue($entity->getId()->equals($userId));
        $this->assertTrue($entity->getPassword()->check('some password'));
        $this->assertFalse($entity->getPassword()->check('wrong'));
    }
}