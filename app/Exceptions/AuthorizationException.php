<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class ModelExceptions
{
    public static function notFound(int $id, string $model)
    {
        return CustomHttpException::new()
            ->setMessage(sprintf('%s with id %s not found', $model, $id))
            ->setHttpCode(Response::HTTP_NOT_FOUND);
    }
}
