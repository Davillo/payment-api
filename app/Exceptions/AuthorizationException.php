<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class AuthorizationException
{
    public static function unauthorized()
    {
        return CustomHttpException::new()
            ->setMessage('Unauthorized')
            ->setHttpCode(Response::HTTP_UNAUTHORIZED);
    }
}
