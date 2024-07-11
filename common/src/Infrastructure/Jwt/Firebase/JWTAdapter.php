<?php

namespace Common\Infrastructure\Jwt\Firebase;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAdapter
{
    public function encode(array $payload): string
    {
        return JWT::encode($payload, $this->getKey(), 'HS256');
    }

    public function decode(string $jwt)
    {
        return JWT::decode($jwt, new Key($this->getKey(), 'HS256'));
    }

    private function getKey(): string
    {
        return 'temporary_hardcoded_key';
    }
}