<?php

namespace Database\Factories;

use App\Helpers\RandomNationalRegistry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'national_registry' => RandomNationalRegistry::cpfRandom(0),
            'email' => $this->faker->unique()->safeEmail,
            'password' => '12345678',
            'type' => Arr::random([User::USER_TYPE_ADMIN, User::USER_TYPE_CUSTOMER, User::USER_TYPE_SHOPKEEPER]),
        ];
    }
}
