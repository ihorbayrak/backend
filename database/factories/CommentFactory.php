<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $posts = Post::all()->pluck('id')->toArray();
        $profiles = Profile::all()->pluck('id')->toArray();

        return [
            'post_id' => fake()->randomElement($posts),
            'profile_id' => fake()->randomElement($profiles),
            'parent_id' => null,
            'body' => fake()->optional(50)->text(),
            'image' => fake()->optional(50)->imageUrl(),
            'created_at' => function (array $attributes) {
                $post = Post::find($attributes['post_id']);

                return fake()->dateTimeBetween($post->created_at);
            },
            'updated_at' => function (array $attributes) {
                $createdAt = $attributes['created_at'];

                return fake()->optional(10)->dateTimeBetween($createdAt);
            },
        ];
    }

    public function configure(): CommentFactory
    {
        return $this->afterCreating(function (Comment $comment) {
            $childComments = Comment::factory(rand(0, 3))->make([
                'post_id' => $comment->post_id,
            ]);

            $comment->replies()->saveMany($childComments);

            $childComments->each(function (Comment $comment) {
                $comment->replies()->saveMany(
                    Comment::factory(rand(0, 2))->make([
                        'post_id' => $comment->post_id,
                    ])
                );
            });
        });
    }
}
