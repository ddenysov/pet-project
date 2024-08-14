<?php

namespace Common\Application\Auth\Port;

interface TokenDecoder
{
    /**
     * @param string $token
     * @param string $key
     * @return array
     */
    public function execute(string $token, string $key): array;
}