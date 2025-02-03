<?php

namespace Common\Application\Repository;

interface HasOffsets
{
    public function limit(int $number): static;

    public function offset(int $number): static;
}