<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Psy\Util\Str;

class PostFactory extends Factory
{
    public function definition()
    {
        $title = $this->faker->jobTitle;
        return [
            Post::WRITER_ID => User::factory()->writer(),
            Post::TITLE     => $title,
            Post::SLUG      => \Illuminate\Support\Str::slug($title),
            Post::BODY      => $this->faker->paragraphs(10, true) . '\n' . $this->faker->paragraphs(20, true),
            Post::COVER     => $this->faker->imageUrl(640, 480, 'technology')
        ];
    }
}
