<?php

declare(strict_types=1);

namespace Zinc\Core\Domain\Value;

use Zinc\Core\Support\Array\AsArray;

interface StringInterface {
    public function toString(): string;
}
