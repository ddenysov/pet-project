<?php

namespace Ride\Delivery\Http\Security;

use Attribute;
use Common\Delivery\Http\Security\Identity;
use Common\Delivery\Http\Security\Port\Policy;

#[Attribute]
class CanCreateRide implements Policy
{
    /**
     * @param Identity $identity
     * @return bool
     */
    public function passes(Identity $identity): bool
    {
        return false;
    }
}