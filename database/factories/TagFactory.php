<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TagFactory extends Factory
{
    public function definition()
    {
        $title = 'tag ' . $this->faker->word;
        return [
            Tag::TITLE => $title,
            Tag::SLUG => Str::slug($title)
        ];
    }
}
