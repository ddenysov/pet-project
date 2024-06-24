<?php

namespace App\Tests\Delivery\Http\Controller;

use App\Tests\Shared\ApiTestCase;

class FindUserControllerTest extends ApiTestCase
{
    public function testCase1(): void
    {
        $this->get('/user/11f4d3ef-a15e-46e1-a1bf-e2c82e66c344');

        $this->assertResponseIsSuccessful();
        $this->assertJsonResponsePathExists('id');
        $this->assertJsonResponsePathExists('name');
        $this->assertJsonResponsePathIsUUID('id');
        $this->assertJsonResponsePathEquals('id', '11f4d3ef-a15e-46e1-a1bf-e2c82e66c344');
        $this->assertJsonResponsePathEquals('name', 'John');
    }

    public function testCase2(): void
    {
        $this->get('/user/0c0a1a41-3f25-4536-87f7-b6468c2901f7');

        $this->assertResponseIsSuccessful();
        $this->assertJsonResponsePathExists('id');
        $this->assertJsonResponsePathExists('name');
        $this->assertJsonResponsePathIsUUID('id');
        $this->assertJsonResponsePathEquals('id', '0c0a1a41-3f25-4536-87f7-b6468c2901f7');
        $this->assertJsonResponsePathEquals('name', 'Jessica');
    }
}
