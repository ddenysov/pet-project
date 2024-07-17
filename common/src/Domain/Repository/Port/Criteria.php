<?php

namespace Common\Domain\Repository\Port;

interface Criteria
{
    public function apply(Repository $repository): void;
}