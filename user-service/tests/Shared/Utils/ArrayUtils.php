<?php

namespace App\Tests\Shared\Utils;

trait ArrayUtils
{
    protected function assertArrayContains(string $key, mixed $value, array $array) {
        $found = false;
        foreach ($array as $k => $v) {
            if ($v[$key] === $value) {
                $found = true;
            }
        }
        $this->assertTrue($found);
    }
}