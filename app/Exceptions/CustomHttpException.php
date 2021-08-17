<?php

namespace App\Exceptions;

use Exception;

class CustomHttpException extends Exception
{
    protected $message = '';

    protected $httpCode = 422;

    public function render()
    {
        return response($this->getError(), $this->httpCode);
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function setHttpCode(int $code): self
    {
        $this->httpCode = $code;
        return $this;
    }

    private function getError()
    {
        return array_filter([
            'message' => $this->message,
        ]);
    }

    public static function new()
    {
        return new static();
    }
}

