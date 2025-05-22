<?php

declare(strict_types=1);

namespace Zinc\Core\DataStore;

/**
 * Composite filter that groups other criteria by logical AND / OR.
 */
final class CompositeCriteria implements \IteratorAggregate
{
    public const TYPE_AND = 'AND';
    public const TYPE_OR  = 'OR';

    /**
     * @param array<Criteria|CompositeCriteria> $parts
     */
    private function __construct(
        public readonly string $type,
        public readonly array  $parts,
    ) {}

    public static function and(Criteria|CompositeCriteria ...$parts): self
    {
        return new self(self::TYPE_AND, $parts);
    }

    public static function or(Criteria|CompositeCriteria ...$parts): self
    {
        return new self(self::TYPE_OR, $parts);
    }

    /**
     * @return \Traversable<Criteria|CompositeCriteria>
     */
    public function getIterator(): \Traversable
    {
        yield from $this->parts;
    }
}
