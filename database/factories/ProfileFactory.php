<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => fake()->unique()->userName(),
            'bio' => fake()->optional()->text(Profile::MAX_BIO_CHARS),
            'avatar' => null,
            'created_at' => function (array $attributes) {
                $user = User::find($attributes['user_id']);

                return $user->created_at;
            },
            'updated_at' => function (array $attributes) {
                $createdAt = $attributes['created_at'];

                return fake()->optional(25)->dateTimeBetween($createdAt);
            }
        ];
    }
}
