<?php

namespace App\Client;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Client
{
    /**
     * @param HttpClientInterface $client
     * @param ParameterBagInterface $params
     */
    public function __construct(
        private HttpClientInterface $client,
        private ParameterBagInterface $params
    )
    {

    }
    public function get()
    {
        return $this->client->request('GET', 'http://' . $this->params->get('user_service') . '/register?name=trololo123');
    }
}