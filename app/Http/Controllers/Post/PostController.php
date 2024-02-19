<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::query()->paginate(2);
        
        $tags = Tag::query()
            ->inRandomOrder()
            ->limit(6)
            ->get()
            ->toArray();

        return view('index', compact('posts', 'tags'));
    }
    
    public function showSinglePost(Post $post, $slug)
    {
        return view('singlepost', compact('post'));
    }
    
    public function getPostByCategories(Category $category)
    {
        
        $posts = Post::query()
            ->whereHas('categories', function ($q) use ($category) {
                $q->where('category_id', $category->id);
            })
            ->paginate(4);
        
        return view('search', compact('posts'));
        
    }
    
    public function getPostByTags(Tag $tag)
    {
        $posts = $tag->posts()->paginate(3);
        
        return view('search', compact('posts'));
    }
}
