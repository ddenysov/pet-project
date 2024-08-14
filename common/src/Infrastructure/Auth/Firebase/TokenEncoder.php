<?php

namespace Common\Infrastructure\Auth\Firebase;

use Common\Application\Auth\Port\TokenEncoder as TokenEncoderPort;
use Firebase\JWT\JWT;

class TokenEncoder implements TokenEncoderPort
{
    /**
     * @param array $payload
     * @param string $key
     * @return string
     */
    public function execute(array $payload, string $key): string
    {
        return JWT::encode($payload, $key, 'HS256');
    }
}