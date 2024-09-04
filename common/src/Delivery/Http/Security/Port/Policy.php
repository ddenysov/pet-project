<?php

namespace Common\Delivery\Http\Security\Port;

use Common\Delivery\Http\Security\Identity;

interface Policy
{
    /**
     * @param Identity $identity
     * @return bool
     */
    public function passes(Identity $identity): bool;
}