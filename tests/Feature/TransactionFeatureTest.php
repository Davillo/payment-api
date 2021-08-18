<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseTransactions;
use TestCase;
use AuthenticationHelper;

class TransactionFeatureTest extends TestCase
{
    use AuthenticationHelper, DatabaseTransactions;

    const TRANSACTION_ENDPOINT = '/transactions';

    public function testShouldReturn200OkWhenListingTransactions()
    {
        $user = User::factory()->count(1)->create()->first();
        $response = $this->actingAs($user)->get(self::TRANSACTION_ENDPOINT);
        $response->assertResponseStatus(Response::HTTP_OK);
    }

    public function testShouldReturn200OkWhenShowingATransaction()
    {
        $user = User::factory()->count(1)->create()->first();
        $transaction = Transaction::factory(['payer_id' => $user->id])->create();
        $response = $this->actingAs($user)->get(self::TRANSACTION_ENDPOINT . "/$transaction->id");

        $response->assertResponseStatus(Response::HTTP_OK);
    }






}
