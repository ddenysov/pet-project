<?php

namespace User\Delivery\Http\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use User\Application\Dto\UserDto;

class UserResponse extends JsonResponse
{
    public function __construct(UserDto $user)
    {
        parent::__construct([
            'id'   => $user->id,
            'name' => $user->name,
        ]);
    }
}