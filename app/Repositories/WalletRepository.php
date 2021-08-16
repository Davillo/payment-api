<?php

namespace App\Repositories;

use App\Models\Wallet;

class WalletRepository extends BaseRepository
{
    public function __construct(Wallet $model = null)
    {
        parent::__construct($model ?? new Wallet());
    }

    public function getByUserId(int $userId): ?Wallet
    {
        return $this->model->where('user_id', $userId)->firstOrFail();
    }
}
