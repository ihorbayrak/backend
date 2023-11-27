<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make(12345678),
            'created_at' => $createdAt = fake()->dateTimeThisYear(),
            'updated_at' => fake()->optional(50, $createdAt)->dateTimeBetween($createdAt),
            'email_verified_at' => fake()->optional(25, $createdAt)->dateTimeBetween($createdAt),
        ];
    }
}
