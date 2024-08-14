<?php

namespace Common\Application\Handlers\Command\Attributes;

use Attribute;

#[Attribute]
class NoTransaction
{
    public function getTransactionManager()
    {

    }
}