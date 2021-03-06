<?php

namespace App\Services;

use App\Exceptions\AuthorizationException;

class AuthenticationService
{
    public const EXPIRES_AT_TIME = 60;

    public function authenticate(array $credentials): array
    {
        $token = auth()->attempt($credentials);

        if(! $token){
            throw AuthorizationException::unauthorized();
        }

        return $this->getTokenData($token);
    }

    public function refresh(string $token): array
    {
        return $this->getTokenData($token);
    }

    public function logout(): void
    {
        auth()->logout();
    }

    private function getTokenData($token): array
    {
        return [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * self::EXPIRES_AT_TIME
        ];
    }
}
