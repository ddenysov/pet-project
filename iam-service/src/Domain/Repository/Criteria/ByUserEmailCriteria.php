<?php

namespace Iam\Domain\Repository\Criteria;

use Iam\Domain\Repository\Port\Criteria\ByUserEmailCriteria as ByUserEmailCriteriaPort;

class ByUserEmailCriteria
{
    public function __construct(private readonly ByUserEmailCriteriaPort $criteriaAdapter)
    {
    }

    public function apply()
    {

    }
}
