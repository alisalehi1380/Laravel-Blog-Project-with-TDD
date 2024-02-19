<?php

namespace Tests\Feature\Writer;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    
    public function test_post_validation_for_test()
    {
        $this->makeWriterLogin();
        $res = $this->post(route('store.post.writer'));
        $res->assertSessionHasErrors('title');
    }
    
    public function test_post_slug_must_be_unique_validation()
    {
        
        $this->makeWriterLogin();
        
        $post = Post::factory()
            ->create();
        
        $cats = Category::factory(3)
            ->create();;
        
        $data = [
            "title"      => 'test title',
            "slug"       => $post->slug,
            "cover"      => '',
            "body"       => 'this is body ',
            "categories" => [0 => 1, 1 => 2, 2 => 3],
            "tags"       => [0 => 'finance', 1 => 'politics', 2 => 'computer'],
        ];
        
        
        $res = $this->post(route('store.post.writer'), $data);
        
        $res->assertSessionHasErrors('slug');
        
    }
    
    public function test_create_new_post()
    {
        $writer = $this->makeWriterLogin();
        
        $cats = Category::factory(4)
            ->create();;
        
        $data = [
            "title"      => 'test title',
            "slug"       => 'test-title',
            "cover"      => '',
            "body"       => 'this is body ',
            "categories" => [0 => 1, 1 => 2, 2 => 3],
            "tags"       => [0 => 'finance', 1 => 'politics', 2 => 'computer'],
        ];
        
        $rep = $this->post(route('store.post.writer'), $data);
        
        $this->assertEquals(1, Post::count());
        
        $this->assertEquals(3, $writer->posts[0]->tags()
            ->count());
        $this->assertEquals(3, $writer->posts[0]->categories()
            ->count());
    }
    
    public function test_writer_posts_list()
    {
        
        $writer = $this->makeWriterLogin();
        
        $posts = Post::factory($writer)
            ->create();
        
        $res = $this->get(route('list.post.writer'));
        
        $res->assertViewIs('writer.list');
        
        $res->assertViewHas('posts');
    }
    
    public function test_select_a_post_foredit()
    {
        $this->withoutExceptionHandling();
        $writer = $this->makeWriterLogin();
        
        $post = Post::factory()
            ->create(['writer_id' => $writer->id]);
        
        
        $categories = Category::factory()
            ->count(5)
            ->create();
        
        $res = $this->get(route('edit.post.writer', $post->id));
        
        $res->assertViewIs('writer.editpost');
        $res->assertViewHas('post');
        $res->assertViewHas('categories');
    }
    
    public function test_only_owner_of_post_can_edit()
    {
        $writer = $this->makeWriterLogin();
        
        $post = Post::factory()
            ->create();
        
        $res = $this->get(route('edit.post.writer', $post->id));
        $res->assertForbidden();
    }
    
    public function test_none_owner_post_not_allowed_for_update()
    {
        
        $writer = $this->makeWriterLogin();
        
        $owner = User::factory()
            ->writer()
            ->create();
        
        $post = Post::factory(['writer_id' => $owner->id])
            ->create();
        
        $res = $this->put(route('update.post.writer', $post->id), ['title' => 'updated title']);
        
        $res->assertForbidden();
    }
    
    public function test_unique_slug_and_required_validation_for_updating_a_post_by_owner()
    {
    }
    
    public function test_updae_a_post_by_owner()
    {
    }
    
    public function test_delete_a_post()
    {
        $this->withoutExceptionHandling();
        
        $writer = $this->makeWriterLogin();
        $post = Post::factory()
            ->state(['writer_id' => $writer->id])
            ->hasCategories(3)
            ->hasTags(3)
            ->create();
        
        $cat_id = $post->categories[0]->category_id;
        $tag_id = $post->tags[0]->tag_id;
        
        
        $res = $this->delete(route('delete.post.writer', $post->id));
        
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
        $this->assertDatabaseMissing('post_tag', ['tag_id' => $tag_id]);
        $this->assertDatabaseMissing('post_category', ['category_id' => $cat_id]);
        
        $res->assertRedirect(route('list.post.writer'));
        
        $res->assertSessionHas('delete-succ', 'Post Deleted SuccessFully');
    }
    
    public function test_only_owner_can_see_comments()
    {
        $writer = $this->makeWriterLogin();
        
        $writer2 = User::factory()
            ->writer()
            ->create();
        
        $post = Post::factory()
            ->state(['writer_id' => $writer2->id])
            ->hasTags(3)
            ->hasCategories(3)
            ->create();
        
        
        $res = $this->get(route('comment.post.writer', $post->id));
        
        $res->assertForbidden();
    }
    
    public function test_show_a_post_comments()
    {
        $writer = $this->makeWriterLogin();
        
        $post = Post::factory()
            ->state(['writer_id' => $writer->id])
            ->hasTags(3)
            ->hasComments(3)
            ->create();
        Comment::factory()
            ->count(10)
            ->state(['post_id' => $post->id])
            ->create();
        
        
        $this->get(route('comment.post.writer', $post->id))
            ->assertViewIs('writer.commentlist');
        
        
    }
    
    public function test_select_post_by_title()
    {
        $write = User::factory()
            ->writer()
            ->create();
        
        $posts = Post::factory()
            ->state(['writer_id' => $write->id, 'body' => 'im body'])
            ->count(10)
            ->hasTags(3)
            ->hasCategories(3)
            ->create();
        
        $this->get(route('get.post.writer', $write->id))
            ->assertViewIs('postlist')
            ->assertViewHas('posts');
        
        $this->assertDatabaseCount('posts', 10);
        
    }
    
    public function test_get_posts_by_category()
    {
        $writer = User::factory()
            ->writer()
            ->create();
        
        $posts = Post::factory()
            ->state(['writer_id' => $writer->id])
            ->count(5)
            ->hasCategories(4)
            ->create();
        
        $cats = Category::query()
            ->limit(1)
            ->get()
            ->pluck('id');
    }
    
    public function makeWriterLogin()
    {
        $writer = User::factory()
            ->writer()
            ->create();
        
        $this->actingAs($writer);
        return $writer;
    }
}
