<?php

namespace Tests\Feature\User;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCommentTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    
    public function test_just_loged_in_user_can_post_a_comment()
    {
        
        $post = Post::factory()
            ->create();
        
        $this->post(route('add.comment.user', $post->id))
            ->assertRedirect(route('login'));
        
    }
    
    public function test_add_a_comment_to_a_post_validation()
    {
        $user = $this->makeNormallUserLogedIn();
        
        $post = self::createPost();
        
        $comment_data = [
            //null data for comment
        ];
        
        
        $this->post(route('add.comment.user', $post->id), $comment_data)
            ->assertSessionHasErrors('text')
            ->assertSessionHasErrors('post_id');
    }
    
    public function test_add_a_comment()
    {
        $user = $this->makeNormallUserLogedIn();
        
        $post = self::createPost();
        
        $comment_data = Comment::factory()
            ->noshow()
            ->state([
                'user_id' => $user->id,
                'post_id' => $post->id,
                'text'    => 'this is comment'
            ])
            ->make();
        
        $res = $this->post(route('add.comment.user', $post->id), $comment_data->toArray());
        $this->assertDatabaseHas('comments', $comment_data->toArray());
    }
    
    private function makeNormallUserLogedIn()
    {
        $user = User::factory()
            ->user()
            ->create();
        $this->actingAs($user);
        return $user;
    }
    
    private static function createPost()
    {
        return Post::factory()
            ->hasTags(3)
            ->hasCategories(3)
            ->create();
    }
}
