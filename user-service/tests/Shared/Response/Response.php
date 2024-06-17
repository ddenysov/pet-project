<?php

namespace App\Tests\Shared\Response;

class Response
{
    /**
     * @param array $response
     */
    public function __construct(private array $response)
    {
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->response;
    }

    /**
     * @param string $path
     * @return bool
     */
    public function jsonPathExists(string $path): bool
    {
        return !!$this->arr($this->response, $path);
    }

    /**
     * @param string $path
     * @return mixed
     */
    public function jsonPath(string $path): mixed
    {
        return $this->arr($this->response, $path);
    }

    private function arr(array $arr, string $path, mixed $default = null) {
        $keys = explode('.', $path);
        $current = $arr;
        foreach ($keys as $key) {
            if (!isset($current[$key])) {
                return $default;
            }
            $current = $current[$key];
        }
        return $current;
    }
}