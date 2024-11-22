<?php

namespace Common\Application\Client\Port;

interface Client
{
    /**
     * @param string $endpoint
     * @param array $query
     * @return array
     */
    public function get(string $endpoint, array $query = []): array;
}