<?php

namespace Common\Application\Auth\Port;

interface TokenEncoder
{
    /**
     * @param array $payload
     * @param string $key
     * @return mixed
     */
    public function execute(array $payload, string $key): string;
}