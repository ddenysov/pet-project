<?php

namespace Common\Application\Storage\Port;

interface Storage
{
    public function find(string $id): array;
    public function store(array $data): void;
}