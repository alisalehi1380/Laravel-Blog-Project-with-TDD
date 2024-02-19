<?php

namespace App\Rules;

use App\Models\Post;
use Illuminate\Contracts\Validation\Rule;

class CheckPostSlugUniqueRule implements Rule
{
    private $post;
    
    public function __construct(Post $post)
    {
        $this->post = $post;
    }
    
    public function passes($attribute, $value)
    {
        $posts = Post::all()->except(['id' => $this->post->id])->toArray();
        
        foreach ($posts as $post) {
            if ($post['slug'] == $value) {
                return false;
            }
        }
        return true;
    }
    
    public function message()
    {
        return 'The Slug Must Be Unique.';
    }
}
