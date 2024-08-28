<?php

namespace Ride\Delivery\Http\Request\Dto;

use Common\Delivery\Http\Request\Dto\Dto;
use Symfony\Component\Validator\Constraints as Assert;

class CreateRideRequest extends Dto
{
    #[Assert\NotBlank]
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}