<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WriterTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    
    public function test_admin_can_see_create_writer_form()
    {
        $admin = User::factory()
            ->admin()
            ->create();
        
        $this->actingAs($admin);
        
        $respo = $this->get(route('new.writer.admin'));
        
        $respo->assertOk();
        
    }
    
    public function test_only_admin_able_to_see_create_wirter_form()
    {
        $this->makeUser();
        
        $response = $this->get(route('new.writer.admin'));
        
        $response->assertForbidden();
    }
    
    public function test_create_writer_validation_error()
    {
        $this->makeAdmin();
        
        $this->post(route('store.writer.admin'))
            ->assertSessionHasErrors(['name', 'email', 'password']);
    }
    
    public function test_create_new_writer()
    {
        $this->makeAdmin();
        
        $data = [
            'name'                  => 'abbas',
            'email'                 => 'adminali@ab.cc',
            'password'              => '12345',
            'password_confirmation' => '12345'
        
        ];
        
        $res = $this->post(route('store.writer.admin'), $data);
        
        $this->assertDatabaseHas('users', [
            'name'  => 'abbas',
            'email' => 'adminali@ab.cc',
            'type'  => 'writer'
        ]);
        
        $res->assertRedirect(route('new.writer.admin'))
            ->assertSessionHas('success', 'new Writer Created Successfully');
        
    }
    
    public function test_writer_list()
    {
        $this->makeAdmin();
        $writers = User::factory()
            ->count(4)
            ->writer()
            ->create();
        
        $resp = $this->get(route('list.writer.admin'));
        
        $resp->assertViewIs('admin.writer.list');
        
        $resp->assertViewHas('writers',
            User::where('type', 'writer')
                ->paginate(2));
    }
    
    public function test_show_writer_posts()
    {
        $this->makeAdmin();
        
        $writer = User::factory()
            ->writer()
            ->hasPosts(3)
            ->create();
        
        $resp = $this->get(route('posts.writer.admin', $writer));
        
        $resp->assertViewIs('admin.writer.writerpostlists');
        
        $resp->assertViewHas('writer', $writer);
        
        
    }
    
    private function makeUser(): void
    {
        $user = User::factory()
            ->user()
            ->create();
        $this->actingAs($user);
    }
    
    private function makeAdmin(): void
    {
        $user = User::factory()
            ->admin()
            ->create();
        $this->actingAs($user);
    }
}
