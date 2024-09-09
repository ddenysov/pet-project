<?php

namespace Ride\Delivery\Http\Request\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UpdatedRideRequest extends CreateRideRequest
{
    /**
     * @param string $id
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct($name);
    }


}