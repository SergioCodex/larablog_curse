<?php

use App\Post;
use App\PostComment;
use Illuminate\Database\Seeder;

class PostCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PostComment::truncate();

        $posts = Post::all()->where("id", "<=", 15);

        foreach ($posts as $key => $post) {
            for ($i = 1; $i <= ($key+1); $i++) {
                PostComment::create([
                    'title' => "título del mensaje $post->title",
                    'message' => "Cuerpo del comentario",
                    'user_id' => 2,
                    'post_id' => $post->id
                ]);
            }
        }

        
    }
}
