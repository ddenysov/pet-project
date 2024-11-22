<?php

namespace Common\Infrastructure\Client\Http\Guzzle;

use Common\Application\Client\Port\PrivateClient;
use GuzzleHttp\Exception\GuzzleException;

class Client implements \Common\Application\Client\Port\Client, PrivateClient
{
    private \GuzzleHttp\Client $client;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    /**
     * @throws GuzzleException
     */
    #[\Override] public function get(string $endpoint, array $query = []): array
    {
        $res = $this->client->request('GET', $endpoint . '?' . http_build_query($query));

        return json_decode($res->getBody()->getContents(), true);
    }
}