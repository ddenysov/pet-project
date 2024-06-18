<?php

namespace App\Tests\Delivery\Http\Controller;

use App\Tests\Shared\ApiTestCase;

class UserControllerTest extends ApiTestCase
{
    public function testSomething(): void
    {
        $this->get('/');

        $this->assertResponseIsSuccessful();
        $this->assertJsonResponsePathExists('id');
        $this->assertJsonResponsePathIsUUID('id');
    }
}
