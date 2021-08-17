<?php

namespace Database\Seeders;

use App\Models\Wallet;
use Illuminate\Database\Seeder;

class WalletsSeeder extends Seeder
{
    public function run(): void
    {
        Wallet::factory()->count(10)->create();
    }
}
