<?php

namespace Iam\Domain\Repository\Criteria;


use Iam\Domain\ValueObject\UserEmail;

class ByUserEmailCriteria
{
    private $builder;

    public function __construct(protected UserEmail $email)
    {
        $this->builder->matchString($this->email->toString());
    }

    public function getBuilder()
    {
        return $this->builder;
    }
}
