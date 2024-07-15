<?php

namespace Iam\Delivery\Http\Request\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class User
{
    public function __construct(
        #[Assert\NotBlank]
        public string $email,
        #[Assert\NotBlank]
        public string $password,
    ) {
    }
}