<?php

namespace Common\Domain\ValueObject;

use Common\Application\Hash\Port\PasswordHasher;
use Common\Domain\ValueObject\Exception\String\InvalidStringLengthException;
use Common\Infrastructure\Hash\Symfony\PasswordHasherAdapter;

class PasswordValue extends StringValue
{
    /**
     * @var PasswordHasher|PasswordHasherAdapter
     */
    private PasswordHasher $hasher;

    /**
     * @param string $value
     * @param bool $hash
     * @throws InvalidStringLengthException
     */
    public function __construct(string $value, bool $hash = false)
    {
        parent::__construct($value);
        $this->hasher = new PasswordHasherAdapter();
        if ($hash) {
            $this->value  = $this->hasher->hash($value);
        }
    }

    /**
     * @param string $password
     * @return bool
     */
    public function check(string $password): bool
    {
        return $this->hasher->valid($this->value, $password);
    }
}