<?php

namespace User\Delivery\Http\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use User\Application\Dto\UserDto;

class CreatedResponse extends JsonResponse
{
    public function __construct()
    {
        parent::__construct([
            'status' => Response::HTTP_CREATED
        ], Response::HTTP_CREATED);
    }
}