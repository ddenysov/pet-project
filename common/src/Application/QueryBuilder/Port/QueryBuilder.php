<?php

namespace Common\Application\QueryBuilder\Port;

interface QueryBuilder
{
    /**
     * @param string $name
     * @return $this
     */
    public function table(string $name): static;

    /**
     * @return array
     */
    public function get(): array;

    /**
     * @param string $column
     * @param string $operand
     * @param string $value
     * @return $this
     */
    public function where(string $column, string $operand, string $value): static;
}