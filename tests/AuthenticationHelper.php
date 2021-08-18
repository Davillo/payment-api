<?php

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

trait AuthenticationHelper
{
    private $headers = [];

    public function actingAs(Authenticatable $user, $driver = null)
    {
        $token = Auth::guard()->fromUser($user);
        parent::actingAs($user, $driver);
        Auth::guard()->setToken($token);

        return $this;
    }
}
