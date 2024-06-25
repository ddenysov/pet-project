<?php

namespace App\Tests\Delivery\Http\Controller;

use App\Tests\Shared\ApiTestCase;
use User\Domain\Model\Entity\User;
use User\Domain\Model\ValueObject\UserId;
use User\Domain\Model\ValueObject\UserName;
use User\Infrastructure\Adapter\Persistence\Memory\Data\OutboxDataset;
use User\Infrastructure\Adapter\Persistence\Memory\Data\UsersDataset;

class RegisterUserControllerTest extends ApiTestCase
{
    public function testCase1(): void
    {
        $data = [
            'name' => 'SomeTestUser',
        ];
        $this->post('/register', $data);

        $this->assertResponseIsSuccessful();

        $users = UsersDataset::$data;
        $outbox = OutboxDataset::$data;
        $this->assertArrayContains('name', $data['name'], $users);
        $this->assertCount(2, $outbox);

    }
}
