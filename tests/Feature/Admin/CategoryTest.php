<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;
    
    public function test_none_admin_redirect()
    {
        $this->makeUserLogin();
        $data = Category::factory()
            ->make()
            ->toArray();
        $resp = $this->post(route('store.category.admin'), $data);
        $resp->assertForbidden();
    }
    
    public function test_create_new_category_route_exist()
    {
        $this->makeAdminlogin();
        $res = $this->get(route('new.category.admin'));
        $res->assertOk();
    }
    
    public function test_view_exist()
    {
        $this->makeAdminlogin();
        $res = $this->get(route('new.category.admin'));
        $res->assertViewIs('admin.category.create');
    }
    
    public function test_check_store_route_exist()
    {
        $this->makeAdminlogin();
        $res = $this->post(route('store.category.admin'));
    }
    
    public function test_validation_check()
    {
        $this->makeAdminlogin();
        $data = ['title' => ''];
        $res = $this->post(route('store.category.admin'), $data);
        $res->assertSessionHasErrors('title');
    }
    
    public function test_validation_duplicate_title()
    {
        $this->makeAdminlogin();
        
        $cat_data = Category::factory()
            ->make();
        Category::query()
            ->create($cat_data->toArray());
        
        $res = $this->post(route('store.category.admin'), $cat_data->toArray());
        
        $res->assertSessionHasErrors('title');
        
    }
    
    public function test_save_unique_category()
    {
        $this->makeAdminlogin();
        
        $cat_data = Category::factory()
            ->make();
        
        $res = $this->post(route('store.category.admin'), $cat_data->toArray());
        
        $this->assertEquals(1, Category::all()
            ->count());
        
        $res->assertRedirect(route('new.category.admin'))
            ->assertSessionHas('success', 'new Category Created SuccessFully');
        
    }
    
    public function test_show_all_categories()
    {
        $this->makeAdminlogin();
        
        
        $resp = $this->get(route('list.category.admin'));
        $resp->assertViewIs('admin.category.list');
        $resp->assertViewHas('categories');
        
        
    }
    
    public function test_edit_category()
    {
        $this->withoutExceptionHandling();
        $this->makeAdminlogin();
        
        $cat = Category::factory()
            ->create();
        
        $res = $this->get(route('edit.category.admin', $cat->id));
        
        $res->assertViewIs('admin.category.edit');
        
        $res->assertViewHas('category');
        
    }
    
    public function test_update_a_category()
    {
        $this->makeAdminlogin();
        
        $category = Category::factory()
            ->create();
        
        $data = ['title' => 'updated'];
        
        $res = $this->put(route('update.category.admin', $category->id), $data);
        
        $this->assertDatabaseHas('categories', [
            'title' => 'updated',
            'slug'  => SLUG('updated')
        ]);
        
        $res->assertRedirect(route('list.category.admin'))
            ->assertSessionHas('success', 'category updated successfully');
    }
    
    private function makeAdminlogin()
    {
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
    }
    
    private function makeUserLogin()
    {
        $user = User::factory()
            ->user()
            ->create();
        $this->actingAs($user);
    }
}
