<?php

declare(strict_types=1);

namespace Zinc\Core\DataStore;

/**
 * Atomic filter expressed as <field, operator, value>.
 */
final class Criteria
{
    public const OP_EQ   = '=';
    public const OP_NE   = '!=';
    public const OP_GT   = '>';
    public const OP_GTE  = '>=';
    public const OP_LT   = '<';
    public const OP_LTE  = '<=';
    public const OP_IN   = 'in';
    public const OP_LIKE = 'like';
    public const OP_REGEX = 'regex';
    public const OP_IS = 'is';
    public const OP_NULL = 'is_null';
    public const OP_NOT_NULL = 'is_not_null';

    public function __construct(
        public readonly string $field,
        public readonly string $operator,
        public readonly mixed  $value = null,
    ) {}

    public static function eq(string $f, mixed $v): self
    {
        return new self($f, self::OP_EQ, $v);
    }

    public static function ne(string $f, mixed $v): self
    {
        return new self($f, self::OP_NE, $v);
    }

    public static function gt(string $f, mixed $v): self
    {
        return new self($f, self::OP_GT, $v);
    }

    public static function gte(string $f, mixed $v): self
    {
        return new self($f, self::OP_GTE, $v);
    }

    public static function lt(string $f, mixed $v): self
    {
        return new self($f, self::OP_LT, $v);
    }

    public static function lte(string $f, mixed $v): self
    {
        return new self($f, self::OP_LTE, $v);
    }

    public static function in(string $f, array $v): self
    {
        return new self($f, self::OP_IN, $v);
    }

    public static function like(string $f, string $v): self
    {
        return new self($f, self::OP_LIKE, $v);
    }

    public static function regex(string $f, string $v): self
    {
        return new self($f, self::OP_REGEX, $v);
    }
}
