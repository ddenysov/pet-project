<?php

namespace Ride\Delivery\Http\Request\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UpdatedRideRequest extends CreateRideRequest
{
    #[Assert\NotBlank]
    public string $id;

    /**
     * @param string $id
     * @param string $name
     */
    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        parent::__construct($name);
    }


}