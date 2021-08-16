<?php

namespace App\Models;

use App\Helpers\StringHelper;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, HasFactory, SoftDeletes;

    const USER_TYPE_CUSTOMER = 'CUSTOMER';
    const USER_TYPE_SHOPKEEPER = 'SHOPKEEPER';
    const USER_TYPE_ADMIN = 'ADMIN';

    protected $fillable = [
        'name', 'email', 'type', 'national_registry', 'password'
    ];

    protected $appends = [
        'wallet'
    ];

    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function getWalletAttribute(){
        return $this->hasOne(Wallet::class)->first();
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function setNationalRegistryAttribute($value)
    {
        $this->attributes['national_registry'] = StringHelper::sanitize($value);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
