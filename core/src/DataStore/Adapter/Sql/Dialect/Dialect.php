<?php
declare(strict_types=1);

namespace Zinc\Core\DataStore\Adapter\Sql\Dialect;

/**
 * Strategy encapsulating SQL flavor specifics.
 */
interface Dialect
{
    public function name(): string;

    public function quote(string $identifier): string;

    public function regexOperator(): ?string;
}
