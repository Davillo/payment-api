<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository extends BaseRepository
{
    public function __construct(Transaction $model = null)
    {
        parent::__construct($model ?? new Transaction());
    }

    public function save(Transaction $transaction)
    {
        $transaction->save();
    }
}
