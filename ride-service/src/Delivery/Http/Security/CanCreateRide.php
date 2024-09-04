<?php

namespace Ride\Delivery\Http\Security;

use Attribute;
use Common\Delivery\Http\Security\Port\Policy;

#[Attribute]
class CanCreateRide implements Policy
{
    /**
     * @return bool
     */
    public function passes(): bool
    {
        return false;
    }
}