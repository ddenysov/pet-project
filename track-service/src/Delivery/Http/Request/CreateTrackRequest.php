<?php

namespace Track\Delivery\Http\Request;

use Common\Delivery\Http\Request\Request as CommonRequest;
use Symfony\Component\Validator\Constraints as Assert;

class CreateTrackRequest extends CommonRequest
{
    public function rules(): Assert\Collection
    {
        return new Assert\Collection([
            'name' => new Assert\NotBlank(),
            'path' => new Assert\NotBlank(),
        ]);
    }
}