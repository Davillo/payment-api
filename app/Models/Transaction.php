<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $appends = [
        'payer',
        'payee'
    ];

    protected $fillable = [
        'payer_id', 'payee_id', 'value'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'payer_id',
        'payee_id'
    ];

    public function payer()
    {
        return $this->hasOne(User::class, 'id', 'payer_id');
    }

    public function payee()
    {
        return $this->hasOne(User::class, 'id', 'payee_id');
    }

    public function getPayerAttribute()
    {
        return $this->payer()->first();
    }

    public function getPayeeAttribute()
    {
        return $this->payee()->first();
    }
}
