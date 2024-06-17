<?php

namespace App\Tests\Delivery\Http\Controller;

use App\Tests\Shared\ApiTest;

class UserControllerTest extends ApiTest
{
    public function testSomething(): void
    {
        $this->get('/');

        $this->assertResponseIsSuccessful();
        $this->assertJsonResponsePathExists('id');
        $this->assertJsonResponsePathIsUUID('id');
    }
}
