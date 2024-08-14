<?php

namespace Common\Infrastructure\Auth\Firebase;

use Common\Application\Auth\Port\TokenDecoder as TokenDecoderPort;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenDecoder implements TokenDecoderPort
{
    /**
     * @param string $token
     * @param string $key
     * @return array
     */
    public function execute(string $token, string $key): array
    {
        $result = JWT::decode($token, new Key($key, 'HS256'));

        return get_object_vars($result);
    }
}