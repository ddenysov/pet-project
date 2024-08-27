<?php

namespace Iam\Delivery\Http\Request\Dto;

use Common\Delivery\Http\Request\Dto\Dto;
use Symfony\Component\Validator\Constraints as Assert;

class NewRideInfo extends Dto
{
    public function __construct(
        #[Assert\NotBlank]
        public string $name,
    ) {
    }
}