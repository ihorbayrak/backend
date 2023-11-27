<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comments = Comment::factory(300)->create();

        foreach ($comments as $comment) {
            if ($comment->body === null && $comment->image === null) {
                $comment->update([
                    'body' => fake()->text()
                ]);
            }

            $comment->profilesLiked()->attach(Profile::all()->random(rand(0, 5)));
        }
    }
}
