<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Profile;
use App\Modules\V1\Geolocation\VO\Coordinates;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $profiles = Profile::all()->pluck('id')->toArray();

        return [
            'profile_id' => fake()->randomElement($profiles),
            'body' => fake()->optional(50)->text(Post::MAX_CHAR),
            'image' => null,
            'activity' => fake()->randomFloat(1, 0, 100),
            'location' => Coordinates::from(fake()->latitude(), fake()->longitude()),
            'created_at' => function (array $attributes) {
                $profile = Profile::find($attributes['profile_id']);

                return fake()->dateTimeBetween($profile->created_at);
            },
            'updated_at' => function (array $attributes) {
                $createdAt = $attributes['created_at'];

                return fake()->optional(25)->dateTimeBetween($createdAt);
            },
        ];
    }
}
