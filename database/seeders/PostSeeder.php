<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::factory(500)->create();

        foreach ($posts as $post) {
            if ($post->body === null && $post->image === null) {
                $post->update([
                    'body' => fake()->text(Post::MAX_CHAR)
                ]);
            }

            $post->profilesLiked()->attach(Profile::all()->random(rand(0, 5)));
            $post->profilesReposted()->attach(Profile::all()->random(rand(0, 3)));
        }
    }
}
