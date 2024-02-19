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
            
            Comment::USER_ID  => User::factory()->user(),
            Comment::POST_ID  => Post::factory(),
            Comment::REPLY_ID => null,
            Comment::SHOW     => true,
            Comment::TEXT     => $this->faker->text(100),
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
                'reply_id' => User::WRITER,
            ];
        });
    }*/
}
