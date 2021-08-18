<?php

namespace Feature;

use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseTransactions;
use TestCase;
use AuthenticationHelper;


class UserFeatureTestTestCase extends TestCase
{
    use AuthenticationHelper, DatabaseTransactions;

    const USER_ENDPOINT = 'users';

    public function testShouldReturn200OkWhenListingUsers()
    {
        $user = User::factory()->count(1)->create()->first();
        $response = $this->actingAs($user)->get(self::USER_ENDPOINT);
        $response->assertResponseStatus(Response::HTTP_OK);
    }

    public function testShouldReturn200OkWhenShowingAUser()
    {
        $user = User::factory()->count(1)->create()->first();
        $response = $this->actingAs($user)->get(self::USER_ENDPOINT . "/$user->id");
        $response->assertResponseStatus(Response::HTTP_OK);
    }

    public function testShouldReturn201CreatedWhenCreatingAUser()
    {
        $user = User::factory()->count(1)->create()->first();
        $userToCreate = array_merge(User::factory()->raw(), ['password_confirmation' => '12345678']);
        $response = $this->actingAs($user)->post(self::USER_ENDPOINT, $userToCreate);
        $response->assertResponseStatus(Response::HTTP_CREATED);
    }

    public function testShouldReturn200WhenUpdatingAUser()
    {
        $user = User::factory()->count(1)->create()->first();
        $response = $this->actingAs($user)->put(self::USER_ENDPOINT . "/$user->id", ['name' => 'test']);
        $response->assertResponseStatus(Response::HTTP_OK);
    }

    public function testShouldReturn204WhenAUserIsDeleted()
    {
        $user = User::factory()->count(1)->create()->first();
        $response = $this->actingAs($user)->delete(self::USER_ENDPOINT . "/$user->id");
        $response->assertResponseStatus(Response::HTTP_NO_CONTENT);
    }

}

