<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseTransactions;
use TestCase;
use AuthenticationHelper;

class AuthenticationFeatureTest extends TestCase
{
    use AuthenticationHelper, DatabaseTransactions;

    const AUTHENTICATION_ENDPOINT = '/auth';

    public function testShouldReturn201WhenAnAuthenticationIsCreatedSuccessfully()
    {
        $user = User::factory()->count(1)->create()->first();
        $credentials = ['email' => $user->email, 'password' => '12345678'];
        $response = $this->post(self::AUTHENTICATION_ENDPOINT, $credentials);
        $response->assertResponseStatus(Response::HTTP_CREATED);
    }

    public function testShouldReturn401WhenThePasswordIsIncorrect()
    {
        $user = User::factory()->count(1)->create()->first();
        $credentials = ['email' => $user->email, 'password' => 'Incorrect'];
        $response = $this->post(self::AUTHENTICATION_ENDPOINT, $credentials);
        $response->assertResponseStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testShouldReturn204WhenAnAuthenticationIsDestroyed()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->delete(self::AUTHENTICATION_ENDPOINT);
        $response->assertResponseStatus(Response::HTTP_NO_CONTENT);
    }
}
