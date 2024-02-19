<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition()
    {
        return [
            
            Comment::col_user_id  => User::factory()->user(),
            Comment::col_post_id  => Post::factory(),
            Comment::col_reply_id => null,
            Comment::col_show     => true,
            Comment::col_text     => $this->faker->text(100),
        ];
    }
    
    public function noshow()
    {
        return $this->state(function (array $attributes) {
            return [
                'show' => false
            ];
        });
    }
    
    /*public function reply()
    {
        return $this->state(function (array $attributes) {
            return [
                'c'
                'reply_id' => User::type_writer,
            ];
        });
    }*/
}
