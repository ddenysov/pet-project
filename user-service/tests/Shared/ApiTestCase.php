<?php

namespace App\Tests\Shared;

use App\Tests\Shared\Response\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Uid\Uuid;

abstract class ApiTestCase extends WebTestCase
{
    /**
     * @param string $url
     * @return void
     */
    protected function get(string $url): void
    {
        $client = static::createClient();
        $client->request('GET', '/');
    }

    /**
     * @return Response
     */
    protected function response(): Response
    {
        return new Response(json_decode(self::getClient()->getResponse()->getContent(), true));
    }

    /**
     * @param string $path
     * @return bool
     */
    protected function assertJsonResponsePathExists(string $path): void
    {
        $this->assertTrue($this->response()->jsonPathExists($path));
    }

    /**
     * @param string $path
     * @return void
     */
    protected function assertJsonResponsePathIsUUID(string $path): void
    {
        $this->assertTrue(Uuid::isValid($this->response()->jsonPath($path)));
    }
}
