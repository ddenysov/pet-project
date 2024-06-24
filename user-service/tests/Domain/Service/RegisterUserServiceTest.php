<?php

namespace App\Tests\Domain\Service;

use User\Domain\Model\Entity\User;
use User\Domain\Model\Event\UserCreated;
use User\Domain\Model\Event\UserRegistered;
use User\Domain\Model\ValueObject\UserId;
use PHPUnit\Framework\TestCase;
use User\Domain\Model\ValueObject\UserName;
use User\Domain\Model\ValueObject\UUID;
use User\Domain\Services\RegisterUserService;

final class RegisterUserServiceTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testCreateIdFromString(): void
    {
        $service = new RegisterUserService();
        $user = $service->execute(
            name: new UserName('Jane Dou')
        );
        $events = $user->releaseEvents();

        $this->assertTrue(\Symfony\Component\Uid\Uuid::isValid($user->getId()->toString()));
        $this->assertEquals('Jane Dou', $user->getName()->toString());
        $this->assertCount(2, $events);
        $this->assertInstanceOf(UserCreated::class, $events[0]);
        $this->assertInstanceOf(UserRegistered::class, $events[1]);
    }
}