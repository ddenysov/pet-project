<?php

declare(strict_types=1);

namespace Zinc\Core\DataStore\Bridge\PDO;

use Zinc\Core\DataStore\{Criteria, CompositeCriteria};
use Zinc\Core\DataStore\Bridge\PDO\Dialect\Dialect;

/**
 * Compile Criteria tree to SQL WHERE clause with bind params.
 */
final class SqlCriteriaCompiler
{
    /**
     * @return array{string,array}
     */
    public function compile(Criteria|CompositeCriteria $crit, Dialect $d): array
    {
        $params = [];
        $sql = $this->walk($crit, $params, $d);
        return [$sql, $params];
    }

    private function walk(Criteria|CompositeCriteria $c, array &$params, Dialect $d): string
    {
        if ($c instanceof Criteria) {
            $ph = ':p' . \count($params);
            if ($c->operator !== Criteria::OP_NULL && $c->operator !== Criteria::OP_NOT_NULL) {
                $params[$ph] = $c->value;
            }

            return match ($c->operator) {
                Criteria::OP_IN   => \sprintf('%s IN (%s)', $d->quote($c->field), $ph),
                Criteria::OP_NULL   => \sprintf('%s IS NULL', $d->quote($c->field)),
                Criteria::OP_NOT_NULL   => \sprintf('%s IS NOT NULL', $d->quote($c->field)),
                Criteria::OP_LIKE => \sprintf('%s LIKE %s', $d->quote($c->field), $ph),
                Criteria::OP_REGEX => $this->compileRegex($d, $c->field, $ph),
                default => \sprintf('%s %s %s', $d->quote($c->field), $c->operator, $ph),
            };
        }

        $glue = $c->type === CompositeCriteria::TYPE_AND ? ' AND ' : ' OR ';
        $parts = \array_map(fn($p) => '(' . $this->walk($p, $params, $d) . ')', $c->parts);
        return \implode($glue, $parts);
    }

    private function compileRegex(Dialect $d, string $field, string $ph): string
    {
        $op = $d->regexOperator();
        if ($op === null) {
            throw new \LogicException('Regex not supported by ' . $d->name());
        }
        return \sprintf('%s %s %s', $d->quote($field), $op, $ph);
    }
}
